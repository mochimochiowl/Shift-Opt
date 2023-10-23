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

class AttendanceRecordController extends Controller
{
    /**
     * at_record 詳細画面を返す
     * @return View
     */
    public function show($at_record_id): View
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
     * データの登録画面（管理者用）を返す
     * @return View
     */
    public function create(): View
    {
        return view('at_records.create');
    }

    /** 
     * at_record データの新規作成
     * @return RedirectResponse
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
            return redirect()->back()->withErrors(['messages' => 'AttendanceRecordController::storeでエラー' . $e->getMessage()])->withInput();
        }
    }

    /**
     * at_record 作成処理を行い、その処理が成功したことを表示する画面を返す
     * @return View
     */
    public function showCreateResult(Request $request): View
    {
        return view('at_records.createResult', [
            'at_record_id' => session('at_record_id'),
            'at_record_labels' => session('at_record_labels'),
            'at_record_data' => session('at_record_data'),
        ]);
    }

    /**
     * at_record 編集画面を返す
     * @return View
     */
    public function edit($at_record_id): View
    {
        $data = AttendanceRecord::searchById($at_record_id)->dataArray();
        return view('at_records.edit', ['data' => $data]);
    }

    /** 
     * at_record データの更新
     * @return RedirectResponse
     *  */
    public function update($at_record_id, AtRecordUpdateRequest $request): RedirectResponse
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
                ->withErrors(['message' => 'AttendanceRecordController::updateでエラー' . $e->getMessage()]);
        }
    }

    /**
     * at_record 更新処理を行い、その処理が成功したことを表示する画面を返す
     * @return View
     */
    public function showUpdateResult(Request $request): View
    {
        return view('at_records.editResult', [
            'at_record_id' => session('at_record_id'),
            'at_record_labels' => session('at_record_labels'),
            'at_record_data' => session('at_record_data'),
            'count' => session('count'),
        ]);
    }

    /**
     * at_record 削除処理の前の確認画面を返す
     * @return View
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
     * @return RedirectResponse
     *  */
    public function destroy($at_record_id): RedirectResponse
    {
        try {
            return DB::transaction(function () use ($at_record_id) {
                $record = AttendanceRecord::searchById($at_record_id);
                if (!$record) {
                    throw new Exception('削除対象の' . ConstParams::AT_RECORD_JP . 'が存在しません。');
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
     * at_record 削除処理を行い、その処理が成功したことを表示する画面を返す
     * @return View
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
