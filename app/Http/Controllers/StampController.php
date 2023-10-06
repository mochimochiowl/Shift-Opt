<?php

namespace App\Http\Controllers;

use App\Models\AttendanceRecord;
use App\Models\User;
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

    /** レコードを新規作成 */
    private function createRecord(Request $request, string $at_record_type)
    {
        try {
            return DB::transaction(function () use ($request, $at_record_type) {

                $user = UserController::findUser($request->login_id);
                if (!$user) {
                    throw new Exception('ユーザーが見つかりません id: ' . $request->login_id);
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
