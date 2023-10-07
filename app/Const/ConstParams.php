<?php

namespace App\Const;

/**
 * 色々なファイルで入力する値をここに集約し、一元管理する
 */

class ConstParams
{
    // 文字数上限の設定
    const EMAIL_CHAR_LIMIT = 200;
    const NAME_CHAR_LIMIT = 15;
    const LOGIN_ID_CHAR_LIMIT = 20;
    const PASSWORD_CHAR_LIMIT = 20;

    // 初期値の設定
    const BY_NAME_DEFAULT = 'デフォルト値';
    const HOURLY_WAGE_DEFAULT = 0.;

    //at_record_typeの設定
    const AT_RECORD_START_WORK = 'start_work';
    const AT_RECORD_FINISH_WORK = 'finish_work';
    const AT_RECORD_START_BREAK = 'start_break';
    const AT_RECORD_FINISH_BREAK = 'finish_break';

    const AT_RECORD_START_WORK_JP = '出勤';
    const AT_RECORD_FINISH_WORK_JP = '退勤';
    const AT_RECORD_START_BREAK_JP = '休憩始';
    const AT_RECORD_FINISH_BREAK_JP = '休憩終';

    //DB 共通のカラムの項目名を定義
    const CREATED_BY = 'created_by';
    const UPDATED_BY = 'updated_by';
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';

    //DB userテーブルのカラムの項目名を定義
    const USER_ID = 'user_id';
    const KANJI_FIRST_NAME = 'kanji_last_name';
    const KANJI_LAST_NAME = 'kanji_first_name';
    const KANA_FIRST_NAME = 'kana_last_name';
    const KANA_LAST_NAME = 'kana_first_name';
    const EMAIL = 'email';
    const EMAIL_VERIFIED_AT = 'email_verified_at';
    const LOGIN_ID = 'login_id';
    const PASSWORD = 'password';
    const REMEMBER_TOKEN = 'remember_token';

    //DB user_salariesテーブルのカラムの項目名を定義
    const USER_SALARY_ID = 'user_salary_id';
    const HOURLY_WAGE = 'hourly_wage';

    //DB user_conditionsテーブルのカラムの項目名を定義
    const USER_CONDITION_ID = 'user_condition_id';
    const HAS_ATTENDED = 'has_attended';
    const IS_BREAKING = 'is_breaking';

    //DB attendance_recordsテーブルのカラムの項目名を定義
    const AT_RECORD_ID = 'at_record_id';
    const AT_RECORD_TYPE = 'at_record_type';
    const AT_RECORD_TIME = 'at_record_time';

    //DB 共通のカラムの表示名を定義
    const CREATED_BY_JP = '新規作成者';
    const UPDATED_BY_JP = '最終更新者';
    const CREATED_AT_JP = '新規作成日時';
    const UPDATED_AT_JP = '最終更新日時';

    //DB userテーブルのカラムの表示名を定義
    const USER_ID_JP = 'ユーザーID';
    const KANJI_FIRST_NAME_JP = '姓（漢字）';
    const KANJI_LAST_NAME_JP = '名（漢字）';
    const KANA_FIRST_NAME_JP = '姓（かな）';
    const KANA_LAST_NAME_JP = '名（かな）';
    const EMAIL_JP = 'メールアドレス';
    const EMAIL_VERIFIED_AT_JP = 'メールアドレス最終認証日時';
    const LOGIN_ID_JP = 'ログインID';
    const PASSWORD_JP = 'パスワード';

    //DB user_salariesテーブルのカラムの表示名を定義
    const USER_SALARY_ID_JP = '時給ID';
    const HOURLY_WAGE_JP = '時給';

    //DB user_conditionsテーブルのカラムの表示名を定義
    const USER_CONDITION_ID_JP = 'コンディションID';
    const HAS_ATTENDED_JP = ConstParams::AT_RECORD_START_WORK_JP . '打刻済みか';
    const IS_BREAKING_JP = ConstParams::AT_RECORD_START_BREAK_JP . '打刻済みか';

    //DB attendance_recordsテーブルのカラムの表示名を定義
    const AT_RECORD_ID_JP = 'レコードID';
    const AT_RECORD_TYPE_JP = 'レコードタイプ';
    const AT_RECORD_TIME_JP = '打刻時刻';
}