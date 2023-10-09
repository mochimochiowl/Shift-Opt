<?php

namespace App\Http\Controllers;

use App\Models\AttendanceRecord;
use App\Models\User;
use App\Models\UserCondition;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Exception;
use App\Const\ConstParams;
use App\Http\Requests\AtRecordStoreRequest;

class StampController extends Controller
{
    public function index(Request $request)
    {
        return view('attend.stamp');
    }
    public function post(Request $request)
    {
        return view('attend.stamp');
    }
    /** 出勤のレコードを新規作成 */
    public function startWork(AtRecordStoreRequest $request)
    {
        return $this->createRecord($request, ConstParams::AT_RECORD_START_WORK);
    }

    /** 退勤のレコードを新規作成 */
    public function finishWork(AtRecordStoreRequest $request)
    {
        return $this->createRecord($request, ConstParams::AT_RECORD_FINISH_WORK);
    }

    /** 休憩始のレコードを新規作成 */
    public function startBreak(AtRecordStoreRequest $request)
    {
        return $this->createRecord($request, ConstParams::AT_RECORD_START_BREAK);
    }

    /** 休憩終のレコードを新規作成 */
    public function finishBreak(AtRecordStoreRequest $request)
    {
        return $this->createRecord($request, ConstParams::AT_RECORD_FINISH_BREAK);
    }

    /** at_record を新規作成、 user_condition を更新*/
    private function createRecord($request, string $at_record_type)
    {
        try {
            return DB::transaction(function () use ($request, $at_record_type) {

                $user = UserController::findUser($request->login_id);
                if (!$user) {
                    throw new Exception('ユーザーが見つかりません login_id: ' . $request->login_id);
                }

                $new_record = AttendanceRecord::query()->create(
                    [
                        ConstParams::USER_ID => $user->user_id,
                        ConstParams::AT_RECORD_TYPE => $at_record_type,
                        ConstParams::AT_RECORD_TIME => getCurrentTime(),
                        ConstParams::CREATED_BY => $user->getKanjiFullName(),
                        ConstParams::UPDATED_BY => $user->getKanjiFullName(),
                    ]
                );

                $userCondition = UserCondition::where('user_id', $user->user_id)->first();
                if (!$user) {
                    throw new Exception('ユーザーコンディションデータが見つかりません login_id: ' . $request->login_id . ' user_id:' . $user->user_id);
                }

                if ($userCondition->has_attended) {
                    switch ($at_record_type) {
                        case ConstParams::AT_RECORD_START_WORK:
                            throw new Exception('既に出勤済みです login_id: ' . $request->login_id . ' user_id:' . $user->user_id . ' has_attended:' . $userCondition->has_attended . ' is_breaking:' . $userCondition->is_breaking);
                        case ConstParams::AT_RECORD_FINISH_WORK:
                            if ($userCondition->is_breaking) {
                                throw new Exception('先に休憩終了をしてください login_id: ' . $request->login_id . ' user_id:' . $user->user_id . ' has_attended:' . $userCondition->has_attended . ' is_breaking:' . $userCondition->is_breaking);
                            } else {
                                $userCondition->has_attended = false;
                                $userCondition->save();
                                break;
                            }
                        case ConstParams::AT_RECORD_START_BREAK:
                            if ($userCondition->is_breaking) {
                                throw new Exception('既に休憩開始済みです login_id: ' . $request->login_id . ' user_id:' . $user->user_id . ' has_attended:' . $userCondition->has_attended . ' is_breaking:' . $userCondition->is_breaking);
                            } else {
                                $userCondition->is_breaking = true;
                                $userCondition->save();
                                break;
                            }
                        case ConstParams::AT_RECORD_FINISH_BREAK:
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
                        case ConstParams::AT_RECORD_START_WORK:
                            if ($userCondition->is_breaking) {
                                throw new Exception('状態がおかしいです（バグ） login_id: ' . $request->login_id . ' user_id:' . $user->user_id . ' has_attended:' . $userCondition->has_attended . ' is_breaking:' . $userCondition->is_breaking);
                            } else {
                                $userCondition->has_attended = true;
                                $userCondition->save();
                                break;
                            }
                        case ConstParams::AT_RECORD_FINISH_WORK:
                        case ConstParams::AT_RECORD_START_BREAK:
                        case ConstParams::AT_RECORD_FINISH_BREAK:
                            throw new Exception('先に出勤をしてください login_id: ' . $request->login_id . ' user_id:' . $user->user_id . ' has_attended:' . $userCondition->has_attended . ' is_breaking:' . $userCondition->is_breaking);
                    }
                }

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

    public function showResult(Request $request)
    {
        return view('attend.result', session('param'));
    }
}
