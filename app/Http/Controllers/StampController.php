<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class StampController extends Controller
{
    public function index(Request $request)
    {
        date_default_timezone_set('Asia/Tokyo');
        $param = [
            'staff_id' => '',
            'pwd' => '',
            'current_time' => getCurrentTime(),
        ];
        return view('attend.stamp', $param);
    }
    public function post(Request $request)
    {
        date_default_timezone_set('Asia/Tokyo');
        $param = [
            'staff_id' => $request->staff_id,
            'pwd' => $request->pwd,
            'current_time' => getCurrentTime(),
        ];
        return view('attend.stamp', $param);
    }
    public function debugShukkin(Request $request)
    {
        date_default_timezone_set('Asia/Tokyo');
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
        date_default_timezone_set('Asia/Tokyo');
        $param = [
            'pagename' => '退勤',
            'staff_id' => $request->staff_id,
            'pwd' => $request->pwd,
            'current_time' => getCurrentTime(),
        ];
        return view('attend.debugResult', $param);
    }
}
