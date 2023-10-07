<?php

namespace App\Http\Controllers;

use App\Models\AttendanceRecord;
use App\Models\User;
use App\Models\UserCondition;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Exception;

class StampController extends Controller
{
    public function index(Request $request)
    {
        $param = [
            'staff_id' => '',
            'pwd' => '',
            'current_time' => getCurrentTime(),
        ];
        return view('attend.stamp', $param);
    }
    public function post(Request $request)
    {
        $param = [
            'staff_id' => $request->staff_id,
            'pwd' => $request->pwd,
            'current_time' => getCurrentTime(),
        ];
        return view('attend.stamp', $param);
    }
    /** 出勤のレコードを新規作成 */
    public function startWork(Request $request)
    {
        return $this->createRecord($request, AT_RECORD_START_WORK);
    }

    /** 退勤のレコードを新規作成 */
    public function finishWork(Request $request)
    {
        return $this->createRecord($request, AT_RECORD_FINISH_WORK);
    }

    /** 休憩始のレコードを新規作成 */
    public function startBreak(Request $request)
    {
        return $this->createRecord($request, AT_RECORD_START_BREAK);
    }

    /** 休憩終のレコードを新規作成 */
    public function finishBreak(Request $request)
    {
        return $this->createRecord($request, AT_RECORD_FINISH_BREAK);
    }

    /** at_record を新規作成、 user_condition を更新*/
    private function createRecord(Request $request, string $at_record_type)
    {
        try {
            return DB::transaction(function () use ($request, $at_record_type) {

                $user = UserController::findUser($request->login_id);
                if (!$user) {
                    throw new Exception('ユーザーが見つかりません login_id: ' . $request->login_id);
                }

                $new_record = AttendanceRecord::query()->create(
                    [
                        'user_id' => $user->user_id,
                        'at_record_type' => $at_record_type,
                        'time' => getCurrentTime(),
                        'created_by' => '新規登録',
                        'updated_by' => '新規登録',
                    ]
                );

                $userCondition = UserCondition::where('user_id', $user->user_id)->first();
                if (!$user) {
                    throw new Exception('ユーザーコンディションデータが見つかりません login_id: ' . $request->login_id . ' user_id:' . $user->user_id);
                }

                if ($userCondition->has_attended) {
                    switch ($at_record_type) {
                        case AT_RECORD_START_WORK:
                            throw new Exception('既に出勤済みです login_id: ' . $request->login_id . ' user_id:' . $user->user_id . ' has_attended:' . $userCondition->has_attended . ' is_breaking:' . $userCondition->is_breaking);
                        case AT_RECORD_FINISH_WORK:
                            if ($userCondition->is_breaking) {
                                throw new Exception('先に休憩終了をしてください login_id: ' . $request->login_id . ' user_id:' . $user->user_id . ' has_attended:' . $userCondition->has_attended . ' is_breaking:' . $userCondition->is_breaking);
                            } else {
                                $userCondition->has_attended = false;
                                $userCondition->save();
                                break;
                            }
                        case AT_RECORD_START_BREAK:
                            if ($userCondition->is_breaking) {
                                throw new Exception('既に休憩開始済みです login_id: ' . $request->login_id . ' user_id:' . $user->user_id . ' has_attended:' . $userCondition->has_attended . ' is_breaking:' . $userCondition->is_breaking);
                            } else {
                                $userCondition->is_breaking = true;
                                $userCondition->save();
                                break;
                            }
                        case AT_RECORD_FINISH_BREAK:
                            if ($userCondition->is_breaking) {
                                $userCondition->is_breaking = false;
                                $userCondition->save();
                                break;
                            } else {
                                throw new Exception('先に休憩開始をしてください login_id: ' . $request->login_id . ' user_id:' . $user->user_id . ' has_attended:' . $userCondition->has_attended . ' is_breaking:' . $userCondition->is_breaking);
                            }
                    }
                } else {
                    switch ($at_record_type) {
                        case AT_RECORD_START_WORK:
                            if ($userCondition->is_breaking) {
                                throw new Exception('状態がおかしいです（バグ） login_id: ' . $request->login_id . ' user_id:' . $user->user_id . ' has_attended:' . $userCondition->has_attended . ' is_breaking:' . $userCondition->is_breaking);
                            } else {
                                $userCondition->has_attended = true;
                                $userCondition->save();
                                break;
                            }
                        case AT_RECORD_FINISH_WORK:
                        case AT_RECORD_START_BREAK:
                        case AT_RECORD_FINISH_BREAK:
                            throw new Exception('先に出勤をしてください login_id: ' . $request->login_id . ' user_id:' . $user->user_id . ' has_attended:' . $userCondition->has_attended . ' is_breaking:' . $userCondition->is_breaking);
                    }
                }

                $userCondition->is_breaking = true;

                $param = [
                    'login_id' => $user->login_id,
                    'name' => $user->getKanjiFullName(),
                    'type' => getAtRecordTypeNameJP($at_record_type),
                    'time' => $new_record->time,
                ];

                return redirect()->route('stampResult', ['param' => $param]);
            }, 5);
        } catch (\Exception $e) {
            return redirect()->route('stamp')->withErrors(['message' => 'There was an error.' . $e->getMessage()]);
        }
    }

    public function showResult(Request $request)
    {
        $param = $request->input('param');
        return view('attend.result', $param);
    }

    public function debugShukkin(Request $request)
    {
        $param = [
            'pagename' => '出勤',
            'staff_id' => $request->staff_id,
            'pwd' => $request->pwd,
            'current_time' => getCurrentTime(),
        ];
        return view('attend.debugResult', $param);
    }
    public function debugTaikin(Request $request)
    {
        $param = [
            'pagename' => '退勤',
            'staff_id' => $request->staff_id,
            'pwd' => $request->pwd,
            'current_time' => getCurrentTime(),
        ];
        return view('attend.debugResult', $param);
    }
}
