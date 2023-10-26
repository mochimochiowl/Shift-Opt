<?php

namespace App\Http\Controllers;

use App\Const\ConstParams;
use App\Http\Requests\AtRecordStoreRequest;
use App\Http\Requests\AtRecordUpdateRequest;
use App\Models\AttendanceRecord;
use App\Models\User;
use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

/**
 * at_recordに関連するモデルやビューを制御する
 * @author mochimochiowl
 * @version 1.0.0
 */
class AttendanceRecordController extends Controller
{
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
                    'target_user_id' => User::findUserByLoginId($request->target_login_id)->user_id,
                    ConstParams::AT_SESSION_ID => $request->input(ConstParams::AT_SESSION_ID),
                    ConstParams::AT_RECORD_TYPE => $request->input(ConstParams::AT_RECORD_TYPE),
                    ConstParams::AT_RECORD_DATE => $request->input(ConstParams::AT_RECORD_DATE),
                    ConstParams::AT_RECORD_TIME => $request->input(ConstParams::AT_RECORD_TIME),
                    ConstParams::CREATED_BY => User::findUserByUserId($request->input('created_by_user_id'))->getKanjiFullName(),
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
     * 打刻レコードの編集画面を返す
     * @param int $at_record_id 更新対象のID
     * @return View 編集画面
     */
    public function edit(int $at_record_id): View
    {
        $data = AttendanceRecord::searchById($at_record_id)->dataArray();
        return view('at_records.edit', ['data' => $data]);
    }

    /** 
     * at_record データの更新
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
     * at_record データの削除
     * @param int $at_record_id 削除対象のID
     * @param AtRecordUpdateRequest $request バリデーション済みのリクエスト
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
    public function showDestroyResult(Request $request): View
    {
        return view('at_records.destroyResult', [
            'at_record_labels' => session('at_record_labels'),
            'at_record_data' => session('at_record_data'),
            'count' => session('count'),
        ]);
    }
}
