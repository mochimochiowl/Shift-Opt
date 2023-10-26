<?php

namespace App\Exceptions;

use Exception;

class ExceptionThrower
{
    public static function saveFailed(string $name, int $code): void
    {
        $msg = $name . 'の保存に失敗しました。 [' . $code . ']';
        throw new Exception($msg);
    }

    public static function fetchFailed(string $name, int $code): void
    {
        $msg = $name . 'の取得に失敗しました。 [' . $code . ']';
        throw new Exception($msg);
    }

    public static function updateFailed(string $name, int $code): void
    {
        $msg = $name . 'の更新に失敗しました。 [' . $code . ']';
        throw new Exception($msg);
    }

    public static function deleteFailed(string $name, int $code): void
    {
        $msg = $name . 'の削除に失敗しました。 [' . $code . ']';
        throw new Exception($msg);
    }

    public static function notEndedSessionsExist(int $code): void
    {
        $msg = '退勤していないセッションが存在します。退勤処理を済ませてから再度お試しください。 [' . $code . ']';
        throw new Exception($msg);
    }

    public static function notExist(string $name, int $code): void
    {
        $msg = '対象の' . $name . 'が存在しません。 [' . $code . ']';
        throw new Exception($msg);
    }
}
