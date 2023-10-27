<?php

declare(strict_types=1);

use App\Const\ConstParams;

/**
 * 現在時刻を取得する
 * @return string 現在時刻(H:i:s)
 */
function getCurrentTime(): string
{
    date_default_timezone_set('Asia/Tokyo');
    return date("H:i:s");
}

/**
 * 今日の日付を取得する
 * @return string 今日の日付(Y/m/d)
 */
function getToday(): string
{
    date_default_timezone_set('Asia/Tokyo');
    return date("Y-m-d");
}

/**
 * 打刻レコードタイプの日本語表記を取得する
 * @return string $at_record_type 対象の打刻レコードタイプ
 * @return string 日本語表記
 */
function getAtRecordTypeNameJP(string $at_record_type): string
{
    switch ($at_record_type) {
        case ConstParams::AT_RECORD_START_WORK:
            return ConstParams::AT_RECORD_START_WORK_JP;
        case ConstParams::AT_RECORD_FINISH_WORK:
            return ConstParams::AT_RECORD_FINISH_WORK_JP;
        case ConstParams::AT_RECORD_START_BREAK:
            return ConstParams::AT_RECORD_START_BREAK_JP;
        case ConstParams::AT_RECORD_FINISH_BREAK:
            return ConstParams::AT_RECORD_FINISH_BREAK_JP;
    }
}
