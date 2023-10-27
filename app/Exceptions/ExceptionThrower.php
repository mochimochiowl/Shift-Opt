<?php

namespace App\Exceptions;

use App\Const\ConstParams;
use Exception;

/**
 * このアプリケーションで使用する例外を管轄する
 * @author mochimochiowl
 * @version 1.0.0
 */
class ExceptionThrower
{
    /**
     * データの作成に失敗したときに投げる
     * @param string $name 作成対象
     * @param int $code エラーコード
     * @return void
     */
    public static function createFailed(string $name, int $code): void
    {
        $msg = $name . 'の作成に失敗しました。 [' . $code . ']';
        throw new Exception($msg);
    }

    /**
     * データの取得に失敗したときに投げる
     * @param string $name 取得対象
     * @param int $code エラーコード
     * @return void
     */
    public static function fetchFailed(string $name, int $code): void
    {
        $msg = $name . 'の取得に失敗しました。 [' . $code . ']';
        throw new Exception($msg);
    }

    /**
     * データの更新に失敗したときに投げる
     * @param string $name 更新対象
     * @param int $code エラーコード
     * @return void
     */
    public static function updateFailed(string $name, int $code): void
    {
        $msg = $name . 'の更新に失敗しました。 [' . $code . ']';
        throw new Exception($msg);
    }

    /**
     * データの削除に失敗したときに投げる
     * @param string $name 削除対象
     * @param int $code エラーコード
     * @return void
     */
    public static function deleteFailed(string $name, int $code): void
    {
        $msg = $name . 'の削除に失敗しました。 [' . $code . ']';
        throw new Exception($msg);
    }

    /**
     * サマリー画面表示用データ取得の際に、退勤していないセッションが存在したら投げる
     * @param int $code エラーコード
     * @return void
     */
    public static function notEndedSessionsExist(int $code): void
    {
        $msg = '退勤していないセッションが存在します。退勤処理を済ませてから再度お試しください。 [' . $code . ']';
        throw new Exception($msg);
    }

    /**
     * 取得したデータが存在しない（null）のときやテーブル上に存在しない場合に投げる
     * @param string $name 対象
     * @param int $code エラーコード
     * @return void
     */
    public static function notExist(string $name, int $code): void
    {
        $msg = '対象の' . $name . 'が存在しません。 [' . $code . ']';
        throw new Exception($msg);
    }

    /**
     * 管理者ユーザー関連のデータを削除しようとしたときに投げる
     * @param string $name 対象
     * @param int $code エラーコード
     * @return void
     */
    public static function unableDeleteAdmin(string $name, int $code): void
    {
        $msg = ConstParams::ADMIN_JP . 'の' . $name . 'は削除できません。 [' . $code . ']';
        throw new Exception($msg);
    }

    /**
     * 正規のルートでないアクセスを検知したときに投げる
     * @param int $code エラーコード
     * @return void
     */
    public static function unauthorizedAccess(int $code): void
    {
        $msg = '不正なアクセスです。' . ' [' . $code . ']';
        throw new Exception($msg);
    }

    /**
     * 任意のエラーメッセージを投げる。上になくて汎用化する必要がない時に使用
     * @param string $error_msg メッセージ
     * @param int $code エラーコード
     * @return void
     */
    public static function genericError(string $error_msg, int $code): void
    {
        $msg = $error_msg . ' [' . $code . ']';
        throw new Exception($msg);
    }
}
