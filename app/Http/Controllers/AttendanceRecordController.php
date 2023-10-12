<?php

namespace App\Http\Controllers;

use App\Const\ConstParams;
use App\Http\Requests\AtRecordUpdateRequest;
use App\Models\AttendanceRecord;
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
        return view('at_records.show', ['record' => $record]);
    }

    /**
     * at_record 編集画面を返す
     * @return View
     */
    public function edit($at_record_id): View
    {
        $record = AttendanceRecord::searchById($at_record_id);
        return view('at_records.edit', ['record' => $record]);
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
                return redirect()
                    ->route('at_records.update.result', [ConstParams::AT_RECORD_ID => $result['record']->at_record_id])
                    ->with(['record' => $result['record'], 'count' => $result['count']]);
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
        return view('at_records.editResult', ['record' => session('record'), 'count' => session('count')]);
    }

    /**
     * at_record 削除処理の前の確認画面を返す
     * @return View
     */
    public function confirmDestroy(Request $request): View
    {
        $record = AttendanceRecord::searchById($request->at_record_id);
        return view('at_records.confirmDestroy', ['record' => $record]);
    }

    /** 
     * at_record データの削除
     * @return RedirectResponse
     *  */
    public function destroy($at_record_id): RedirectResponse
    {
        try {
            return DB::transaction(function () use ($at_record_id) {
                $count = AttendanceRecord::deletedById($at_record_id);
                return redirect()->route('at_records.delete.result', [ConstParams::AT_RECORD_ID => $at_record_id])->with(['count' => $count]);
            }, 5);
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['message' => 'AttendanceRecordController::destroyでエラー' . $e->getMessage()]);
        }
    }

    /**
     * at_record 削除処理を行い、その処理が成功したことを表示する画面を返す
     * @return View
     */
    public function showDestroyResult(Request $request): View
    {
        return view('users.destroyResult', ['count' => session('count')]);
    }
}
