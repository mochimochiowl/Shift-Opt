<?php

namespace App\Http\Controllers;

use App\Const\ConstParams;
use App\Http\Requests\AtRecordStoreRequest;
use App\Models\AttendanceRecord;
use App\Models\User;
use App\Models\UserCondition;
use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class StampController extends Controller
{
    /**
     * 打刻画面を返す
     * @return View
     */
    public function index(): View
    {
        return view('stamps.index');
    }

    /** 
     * 出勤のat_record を新規作成（createRecord関数への中継関数）
     * @return RedirectResponse
     *  */
    public function startWork(AtRecordStoreRequest $request): RedirectResponse
    {
        return $this->createRecord($request, ConstParams::AT_RECORD_START_WORK);
    }

    /** 
     * 退勤のat_record を新規作成（createRecord関数への中継関数）
     * @return RedirectResponse
     *  */
    public function finishWork(AtRecordStoreRequest $request): RedirectResponse
    {
        return $this->createRecord($request, ConstParams::AT_RECORD_FINISH_WORK);
    }

    /** 
     * 休憩始のat_record を新規作成（createRecord関数への中継関数）
     * @return RedirectResponse
     *  */
    public function startBreak(AtRecordStoreRequest $request): RedirectResponse
    {
        return $this->createRecord($request, ConstParams::AT_RECORD_START_BREAK);
    }

    /** 
     * 休憩終のat_record を新規作成（createRecord関数への中継関数）
     * @return RedirectResponse
     *  */
    public function finishBreak(AtRecordStoreRequest $request): RedirectResponse
    {
        return $this->createRecord($request, ConstParams::AT_RECORD_FINISH_BREAK);
    }

    /** 
     * at_record を新規作成、 user_condition を更新
     * @return RedirectResponse
     *  */
    private function createRecord($request, string $at_record_type): RedirectResponse
    {
        try {
            return DB::transaction(function () use ($request, $at_record_type) {

                $user = User::findUserByLoginId($request->login_id);
                if (!$user) {
                    throw new Exception('ユーザーが見つかりません login_id: ' . $request->login_id);
                }
                $userCondition = UserCondition::where('user_id', $user->user_id)->first();
                if (!$userCondition) {
                    throw new Exception('ユーザーコンディションデータが見つかりません login_id: ' . $request->login_id . ' user_id:' . $user->user_id);
                }

                $new_record = AttendanceRecord::createNewRecord($user, $at_record_type);
                $userCondition->updateInfo($user, $at_record_type);

                $param = [
                    'user' => $user,
                    'type' => getAtRecordTypeNameJP($at_record_type),
                    'time' => $new_record->at_record_time,
                ];
                return redirect()->route('stamps.result')->with(['param' => $param]);
            }, 5);
        } catch (\Exception $e) {
            return redirect()->route('stamps.index')->withErrors(['message' => 'There was an error.' . $e->getMessage()])->withInput();
        }
    }

    /**
     * 打刻処理成功画面を返す
     * @return View
     */
    public function showResult(Request $request): View
    {
        return view('stamps.result', session('param'));
    }
}
