<?php

declare(strict_types=1);

use App\Const\ConstParams;

/**
 * 現在時刻(H:i:s)を取得する
 * @return string
 */
function getCurrentTime(): string
{
    date_default_timezone_set('Asia/Tokyo');
    return date("H:i:s");
}

/**
 * 今日の日付(Y/m/d)を取得する
 * @return string
 */
function getToday(): string
{
    date_default_timezone_set('Asia/Tokyo');
    return date("Y-m-d");
}

/**
 * AT_RECORD_TYPEの日本語表記を取得する
 * @return string
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
