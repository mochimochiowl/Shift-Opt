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

/**
 * 検索用の属性「search_field」に対応する日本語表記の項目名を返す
 * @return string 日本語表記の項目名
 */
function getFieldNameJP(string $search_field): string
{
    switch ($search_field) {
        case ConstParams::USER_ID:
            return ConstParams::USER_ID_JP;
        case ConstParams::LOGIN_ID:
            return ConstParams::LOGIN_ID_JP;
        case 'name':
            return '名前（漢字・かな）';
        case ConstParams::EMAIL:
            return ConstParams::EMAIL_JP;
        case 'all':
            return '全件表示';
    }
}
