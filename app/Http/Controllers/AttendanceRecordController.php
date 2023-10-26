<?php

namespace App\Http\Controllers;

use App\Const\ConstParams;
use App\Http\Requests\AtRecordStoreRequest;
use App\Http\Requests\AtRecordUpdateRequest;
use App\Http\Requests\SearchAtRecordsRequest;
use App\Http\Services\SearchService;
use App\Models\AttendanceRecord;
use App\Models\User;
use Exception;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\View\View;

/**
 * at_recordに関連するモデルやビューを制御する
 * @author mochimochiowl
 * @version 1.0.0
 */
class AttendanceRecordController extends Controller
{
    /**
     * 打刻レコードの登録画面（打刻画面ではない）を返す
     * @return View 登録画面
     */
    public function create(): View
    {
        return view('at_records.create');
    }

    /** 
     * 打刻レコードを新規作成する
     * @param AtRecordStoreRequest $request バリデーション済みのリクエスト
     * @return RedirectResponse 作成結果画面か、前の画面へのリダイレクト
     *  */
    public function store(AtRecordStoreRequest $request): RedirectResponse
    {
        try {
            return DB::transaction(function () use ($request) {
                $data = [
                    'target_user_id' => User::findByLoginId($request->target_login_id)->user_id,
                    ConstParams::AT_SESSION_ID => $request->input(ConstParams::AT_SESSION_ID),
                    ConstParams::AT_RECORD_TYPE => $request->input(ConstParams::AT_RECORD_TYPE),
                    ConstParams::AT_RECORD_DATE => $request->input(ConstParams::AT_RECORD_DATE),
                    ConstParams::AT_RECORD_TIME => $request->input(ConstParams::AT_RECORD_TIME),
                    ConstParams::CREATED_BY => User::findByUserId($request->input('created_by_user_id'))->getKanjiFullName(),
                ];

                $new_record_id = AttendanceRecord::createNewRecord($data)->at_record_id;
                $record = AttendanceRecord::searchById($new_record_id);

                $at_record_labels = $record->labels();
                $at_record_data = $record->data();

                return redirect()->route('at_records.create.result', [
                    ConstParams::AT_RECORD_ID => $new_record_id,
                ])->with([
                    'at_record_id' => $new_record_id,
                    'at_record_labels' => $at_record_labels,
                    'at_record_data' => $at_record_data,
                ]);
            }, 5);
        } catch (Exception $e) {
            return redirect()->back()->withErrors(['messages' => $e->getMessage()])->withInput();
        }
    }

    /**
     * 打刻レコードの新規作成結果画面を返す
     * @return View 結果表示画面
     */
    public function showCreateResult(): View
    {
        return view('at_records.createResult', [
            'at_record_id' => session('at_record_id'),
            'at_record_labels' => session('at_record_labels'),
            'at_record_data' => session('at_record_data'),
        ]);
    }

    /**
     * 打刻レコード詳細画面を返す
     * @param int $at_record_id 表示対象のID
     * @return View 詳細画面
     */
    public function show(int $at_record_id): View
    {
        $record = AttendanceRecord::searchById($at_record_id);
        $at_record_labels = $record->labels();
        $at_record_data = $record->data();
        return view('at_records.show', [
            'at_record_id' => $record->at_record_id,
            'at_record_labels' => $at_record_labels,
            'at_record_data' => $at_record_data,
        ]);
    }

    /**
     * 打刻レコード検索画面を返す
     * @param Request $request バリデーション未実施のリクエスト
     * @return View|RedirectResponse 検索画面
     */
    public function showSearchPage(Request $request): View | RedirectResponse
    {
        if ($request->input('column')) {
            // 検索ボタンを押下したとき

            // カスタムフォームリクエストを初めから利用すると、
            // リダイレクトループが発生してしまうため、あえてここでバリエーション実行
            $validator = Validator::make(
                $request->all(),
                (new SearchAtRecordsRequest)->rules(),
                (new SearchAtRecordsRequest)->messages(),
                (new SearchAtRecordsRequest)->attributes(),
            );

            if ($validator->fails()) {
                return redirect('at_records/search')
                    ->withErrors($validator)
                    ->withInput();
            }

            $validated_data = $validator->validated();
            $formatted_data = SearchService::formatAtRecordSearchRequirements(false, $validated_data);
            $results = $this->search($formatted_data['search_requirements'], false);
        } else {
            // 検索画面を最初に開いたとき
            $formatted_data = SearchService::formatAtRecordSearchRequirements(true);
            $results = null;
        }

        return view('at_records/search', [
            'results' => $results,
            'search_requirements' => $formatted_data['search_requirements'],
            'search_requirement_labels' => $formatted_data['search_requirement_labels'],
            'search_requirements_data' => $formatted_data['search_requirements_data'],
            'default_dates' => $formatted_data['default_dates'],
        ]);
    }

    /**
     * 検索条件に基づき、打刻レコードの検索結果をCSVで出力する
     * @param Request $request バリデーション未実施のリクエスト
     * @return Response CSVのダウンロードが開始
     */
    public function exportCsv(SearchAtRecordsRequest $request): Response
    {
        $validated_data = $request->validated();
        $formatted_data = SearchService::formatAtRecordSearchRequirements(false, $validated_data);
        $results = $this->search($formatted_data['search_requirements'], true);
        $response_data = SearchService::createCSV($formatted_data, $results);

        return response($response_data['csv'], 200)
            ->withHeaders($response_data['headers']);
    }

    /**
     * 検索条件に基づき、打刻レコードを検索する
     * @param array $search_requirements 検索条件
     * @param bool $asArray 検索結果を配列で受け取るかどうか
     * @return LengthAwarePaginator|array 検索結果
     */
    private function search(array $search_requirements, bool $asArray): LengthAwarePaginator | array
    {
        return AttendanceRecord::search($search_requirements, $asArray);
    }

    /**
     * 打刻レコード編集画面を返す
     * @param int $at_record_id 更新対象のID
     * @return View 編集画面
     */
    public function edit(int $at_record_id): View
    {
        $data = AttendanceRecord::searchById($at_record_id)->dataArray();
        return view('at_records.edit', ['data' => $data]);
    }

    /** 
     * 打刻レコードを更新する
     * @param int $at_record_id 更新対象のID
     * @param AtRecordUpdateRequest $request バリデーション済みのリクエスト
     * @return RedirectResponse  更新結果画面か、前の画面へのリダイレクト
     *  */
    public function update(int $at_record_id, AtRecordUpdateRequest $request): RedirectResponse
    {
        try {
            return DB::transaction(function () use ($at_record_id, $request) {
                $data = $request->validated();
                $result = AttendanceRecord::updateInfo($at_record_id, $data);
                $record = AttendanceRecord::searchById($at_record_id);
                $at_record_labels = $record->labels();
                $at_record_data = $record->data();
                return redirect()
                    ->route('at_records.update.result', [ConstParams::AT_RECORD_ID => $result['data'][ConstParams::AT_RECORD_ID]])
                    ->with([
                        'at_record_id' => $record->at_record_id,
                        'at_record_labels' => $at_record_labels,
                        'at_record_data' => $at_record_data,
                        'count' => $result['count'],
                    ]);
            }, 5);
        } catch (Exception $e) {
            return redirect()
                ->back()
                ->withErrors(['message' => $e->getMessage()]);
        }
    }

    /**
     * 打刻レコードの更新結果画面を返す
     * @return View 結果表示画面
     */
    public function showUpdateResult(): View
    {
        return view('at_records.editResult', [
            'at_record_id' => session('at_record_id'),
            'at_record_labels' => session('at_record_labels'),
            'at_record_data' => session('at_record_data'),
            'count' => session('count'),
        ]);
    }

    /**
     * 打刻レコードの削除確認画面を返す
     * @param Request $request IDを受け取るために使う
     * @return View 確認画面
     */
    public function confirmDestroy(Request $request): View
    {
        $record = AttendanceRecord::searchById($request->at_record_id);
        $at_record_labels = $record->labels();
        $at_record_data = $record->data();
        return view('at_records.confirmDestroy', [
            'at_record_id' => $record->at_record_id,
            'at_record_labels' => $at_record_labels,
            'at_record_data' => $at_record_data,
        ]);
    }

    /** 
     * 打刻レコードを削除する
     * @param int $at_record_id 削除対象のID
     * @return RedirectResponse  削除結果画面か、前の画面へのリダイレクト
     */
    public function destroy(int $at_record_id): RedirectResponse
    {
        try {
            return DB::transaction(function () use ($at_record_id) {
                $record = AttendanceRecord::searchById($at_record_id);
                if (!$record) {
                    ExceptionThrower::notExist(ConstParams::AT_RECORD_JP);
                }
                $at_record_labels = $record->labels();
                $at_record_data = $record->data();
                $count = AttendanceRecord::deletedById($at_record_id);
                return redirect()->route('at_records.delete.result', [
                    ConstParams::AT_RECORD_ID => $at_record_id,
                ])->with([
                    'at_record_labels' => $at_record_labels,
                    'at_record_data' => $at_record_data,
                    'count' => $count,
                ]);
            }, 5);
        } catch (\Exception $e) {
            return redirect()->route('at_records.search')->withErrors(['message' => $e->getMessage()]);
        }
    }

    /**
     * 打刻レコードの削除結果画面を返す
     * @return View 結果表示画面
     */
    public function showDestroyResult(): View
    {
        return view('at_records.destroyResult', [
            'at_record_labels' => session('at_record_labels'),
            'at_record_data' => session('at_record_data'),
            'count' => session('count'),
        ]);
    }
}
