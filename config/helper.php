<?php

declare(strict_types=1);

/**
 * 現在時刻を取得する
 * @return string
 */
function getCurrentTime(): string
{
    date_default_timezone_set('Asia/Tokyo');
    return date("Y/m/d H:i:s");
}

/**
 * AT_RECORD_TYPEの日本語表記を取得する
 * @return string
 */
function getAtRecordTypeNameJP(string $at_record_type): string
{
    switch ($at_record_type) {
        case AT_RECORD_START_WORK:
            return AT_RECORD_START_WORK_JP;
        case AT_RECORD_FINISH_WORK:
            return AT_RECORD_FINISH_WORK_JP;
        case AT_RECORD_START_BREAK:
            return AT_RECORD_START_BREAK_JP;
        case AT_RECORD_FINISH_BREAK:
            return AT_RECORD_FINISH_BREAK_JP;
    }
}
