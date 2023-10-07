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

//DB 共通のカラムの表示名を定義
define('CREATED_BY_JP', '新規作成者');
define('UPDATED_BY_JP', '最終更新者');
define('CREATED_AT_JP', '新規作成日時');
define('UPDATED_AT_JP', '最終更新日時');

//DB userテーブルのカラムの表示名を定義
define('USER_ID_JP', 'ユーザーID');
define('KANJI_FIRST_NAME_JP', '姓（漢字）');
define('KANJI_LAST_NAME_JP', '名（漢字）');
define('KANA_FIRST_NAME_JP', '姓（漢字）');
define('KANA_LAST_NAME_JP', '名（漢字）');
define('EMAIL_JP', 'メールアドレス');
define('EMAIL_VERIFIED_AT_JP', 'メールアドレス最終認証日時');
define('LOGIN_ID_JP', 'ログインID');
define('PASSWORD_JP', 'パスワード');

//DB user_salariesテーブルのカラムの表示名を定義
define('SALARY_ID_JP', '時給ID');
define('HOURLY_WAGE_JP', '時給');

//DB user_conditionsテーブルのカラムの表示名を定義
define('CONDITION_ID_JP', 'コンディションID');
define('HAS_ATTENDED_JP', AT_RECORD_START_WORK_JP . '打刻済みか');
define('IS_BREAKING_JP', AT_RECORD_START_BREAK_JP . '打刻済みか');

//DB attendance_recordsテーブルのカラムの表示名を定義
define('AT_RECORD_ID_JP', 'レコードID');
define('AT_RECORD_TYPE_JP', 'レコードタイプ');
define('AT_RECORD_TIME_JP', '打刻時刻');
