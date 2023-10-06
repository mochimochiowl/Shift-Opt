<?php
// 文字数上限の設定
define('EMAIL_CHAR_LIMIT', 200);
define('NAME_CHAR_LIMIT', 15);
define('LOGIN_ID_CHAR_LIMIT', 20);
define('PASSWORD_CHAR_LIMIT', 20);

// 初期値の設定
define('BY_NAME_DEFAULT', 'デフォルト値');
define('HOURLY_WAGE_DEFAULT', 0.);

//at_record_typeの設定
define('AT_RECORD_START_WORK', 'start_work');
define('AT_RECORD_FINISH_WORK', 'finish_work');
define('AT_RECORD_START_BREAK', 'start_break');
define('AT_RECORD_FINISH_BREAK', 'finish_break');

define('AT_RECORD_START_WORK_JP', '出勤');
define('AT_RECORD_FINISH_WORK_JP', '退勤');
define('AT_RECORD_START_BREAK_JP', '休憩始');
define('AT_RECORD_FINISH_BREAK_JP', '休憩終');
