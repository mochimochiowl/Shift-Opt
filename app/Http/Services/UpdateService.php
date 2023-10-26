<?php

namespace App\Http\Services;

use App\Const\ConstParams;

/**
 * ユーザーの更新に関連するビジネスロジックを管轄する
 * @author mochimochiowl
 * @version 1.0.0
 */
class UpdateService
{
    /**
     * ユーザーレコードの更新に必要なデータを整形する
     * @param array $data バリエーション済みのデータ
     * @return array 整形済みのデータの配列
     */
    public static function formatDataForUser(array $data): array
    {
        $logged_in_user = Auth::user();

        $updated_by = $logged_in_user->getKanjiFullName();

        // ログインユーザー自身の情報を更新する場合、
        // 変更後の氏名（＝最新の氏名）を最終更新者に記録するようにする
        if ($data[ConstParams::USER_ID] == $logged_in_user->user_id) {
            $updated_by = $data[ConstParams::KANJI_LAST_NAME] . ' ' . $data[ConstParams::KANJI_FIRST_NAME];
        }

        $formatted_data = [
            ConstParams::USER_ID => $data[ConstParams::USER_ID],
            ConstParams::KANJI_LAST_NAME => $data[ConstParams::KANJI_LAST_NAME],
            ConstParams::KANJI_FIRST_NAME => $data[ConstParams::KANJI_FIRST_NAME],
            ConstParams::KANA_LAST_NAME => $data[ConstParams::KANA_LAST_NAME],
            ConstParams::KANA_FIRST_NAME => $data[ConstParams::KANA_FIRST_NAME],
            ConstParams::EMAIL => $data[ConstParams::EMAIL],
            ConstParams::LOGIN_ID => $data[ConstParams::LOGIN_ID],
            ConstParams::IS_ADMIN => $data[ConstParams::IS_ADMIN],
            ConstParams::UPDATED_BY => $updated_by,
        ];

        return $formatted_data;
    }
}
