<?php

namespace App\Http\Controllers;

use App\Const\ConstParams;
use App\Http\Requests\AtRecordStoreRequest;
use App\Http\Requests\StampRequest;
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
    public function startWork(StampRequest $request): RedirectResponse
    {
        $data = [
            'target_login_id' => $request->input('target_login_id'),
            'at_record_type' => ConstParams::AT_RECORD_START_WORK,
        ];
        return $this->createRecord($data);
    }

    /** 
     * 退勤のat_record を新規作成（createRecord関数への中継関数）
     * @return RedirectResponse
     *  */
    public function finishWork(StampRequest $request): RedirectResponse
    {
        $data = [
            'target_login_id' => $request->input('target_login_id'),
            'at_record_type' => ConstParams::AT_RECORD_FINISH_WORK,
        ];
        return $this->createRecord($data);
    }

    /** 
     * 休憩始のat_record を新規作成（createRecord関数への中継関数）
     * @return RedirectResponse
     *  */
    public function startBreak(StampRequest $request): RedirectResponse
    {
        $data = [
            'target_login_id' => $request->input('target_login_id'),
            'at_record_type' => ConstParams::AT_RECORD_START_BREAK,
        ];
        return $this->createRecord($data);
    }

    /** 
     * 休憩終のat_record を新規作成（createRecord関数への中継関数）
     * @return RedirectResponse
     *  */
    public function finishBreak(StampRequest $request): RedirectResponse
    {
        $data = [
            'target_login_id' => $request->input('target_login_id'),
            'at_record_type' => ConstParams::AT_RECORD_FINISH_BREAK,
        ];
        return $this->createRecord($data);
    }

    /** 
     * at_record を新規作成、 user_condition を更新
     * @return RedirectResponse
     *  */
    private function createRecord(array $data): RedirectResponse
    {
        try {
            return DB::transaction(function () use ($data) {

                $target_user = User::findUserByLoginId($data['target_login_id']);

                $user_condition = UserCondition::where('user_id', $target_user->user_id)->first();
                if (!$user_condition) {
                    throw new Exception('ユーザーコンディションデータが見つかりません login_id: ' . $target_user->login_id . ' user_id:' . $target_user->user_id);
                }

                $modified_data = [
                    'target_user_id' => $target_user->user_id,
                    'at_record_type' => $data['at_record_type'],
                    'at_record_time' => getCurrentTime(),
                    'created_by' => $target_user->getKanjiFullName(),
                ];

                $new_record = AttendanceRecord::createNewRecord($modified_data);
                $user_condition->validateConditions($target_user, $modified_data['at_record_type']);

                $param = [
                    'user' => $target_user,
                    'type' => getAtRecordTypeNameJP($modified_data['at_record_type']),
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
