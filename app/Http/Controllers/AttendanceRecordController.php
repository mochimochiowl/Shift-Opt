<?php

namespace App\Http\Controllers;

use App\Const\ConstParams;
use App\Models\AttendanceRecord;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AttendanceRecordController extends Controller
{
    /**
     * at_record 詳細画面を返す
     * @return View
     */
    public function show($at_record_id): View
    {
        $record = AttendanceRecord::where(ConstParams::AT_RECORD_ID, '=', $at_record_id)->first();
        //Viewで加工しないようにするため、at_record_typeのカラムのみ、画面表示用に日本語表記の文字列に差し替え
        $record->at_record_type = AttendanceRecord::getTypeName($record->at_record_type);
        return view('at_records.show', ['record' => $record]);
    }

    /**
     * at_record 編集画面を返す
     * @return View
     */
    public function edit($at_record_id): View
    {
        $at_record = AttendanceRecord::where(ConstParams::AT_RECORD_ID, '=', $at_record_id)->first();
        return view('at_records.edit', ['record' => $at_record]);
    }

    /** 
     * at_record データの更新
     * @return RedirectResponse
     *  */
    public function update($user_id, UserUpdateRequest $request): RedirectResponse
    {
        try {
            return DB::transaction(function () use ($user_id, $request) {
                $data = $request->validated();
                $result = User::updateInfo($user_id, $data);
                return redirect()
                    ->route('users.update.result', [ConstParams::USER_ID => $result['user']->user_id])
                    ->with(['user' => $result['user'], 'count' => $result['count']]);
            }, 5);
        } catch (Exception $e) {
            return redirect()
                ->back()
                ->withErrors(['message' => 'UserController::updateでエラー' . $e->getMessage()]);
        }
    }

    /**
     * at_record 更新処理を行い、その処理が成功したことを表示する画面を返す
     * @return View
     */
    public function showUpdateResult(Request $request): View
    {
        return view('users.editResult', ['user' => session('user'), 'count' => session('count')]);
    }

    /**
     * at_record 削除処理の前の確認画面を返す
     * @return View
     */
    public function confirmDestroy(Request $request): View
    {
        $user = User::where('user_id', $request->user_id)->first();
        return view('users.confirmDestroy', ['user' => $user]);
    }

    /** 
     * at_record データの削除
     * @return RedirectResponse
     *  */
    public function destroy($user_id): RedirectResponse
    {
        try {
            return DB::transaction(function () use ($user_id) {
                $count = User::deletedById($user_id);
                return redirect()->route('users.delete.result', [ConstParams::USER_ID => $user_id])->with(['count' => $count]);
            }, 5);
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['message' => 'UserController::destroyでエラー' . $e->getMessage()]);
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
