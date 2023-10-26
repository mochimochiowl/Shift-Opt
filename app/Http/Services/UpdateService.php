<?php

namespace App\Http\Services;

use App\Const\ConstParams;
use Illuminate\Support\Facades\Auth;

/**
 * ユーザーの更新に関連するビジネスロジックを管轄する
 * @author mochimochiowl
 * @version 1.0.0
 */
class UpdateService
{
    /**
     * ユーザーレコードの更新に必要なデータを整形する
     * @param int $user_id 更新対象のID
     * @param array $data バリエーション済みのデータ
     * @return array 整形済みのデータの配列
     */
    public static function formatDataForUser(int $user_id, array $data): array
    {
        /** @var \App\Models\User $logged_in_user */
        $logged_in_user = Auth::user();

        $updated_by = $logged_in_user->getKanjiFullName();

        // ログインユーザー自身の情報を更新する場合、
        // 変更後の氏名（＝最新の氏名）を最終更新者に記録するようにする
        if ($user_id == $logged_in_user->user_id) {
            $updated_by = $data[ConstParams::KANJI_LAST_NAME] . ' ' . $data[ConstParams::KANJI_FIRST_NAME];
        }

        $formatted_data = [
            ConstParams::USER_ID => $user_id,
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

    /**
     * 時給データの更新に必要なデータを整形する
     * @param array $validated_data バリエーション済みのデータ
     * @param array $salary_data 現状の時給データ
     * @return array 整形済みのデータの配列
     */
    public static function formatDataForUserSalary(array $validated_data, array $salary_data): array
    {
        /** @var \App\Models\User $logged_in_user */
        $logged_in_user = Auth::user();

        $formatted_data = [
            ConstParams::USER_SALARY_ID => $salary_data[ConstParams::USER_SALARY_ID],
            ConstParams::HOURLY_WAGE => $validated_data[ConstParams::HOURLY_WAGE],
            ConstParams::UPDATED_BY => $logged_in_user->getKanjiFullName(),
        ];

        return $formatted_data;
    }

    /**
     * コンディションデータの更新に必要なデータを整形する
     * @param array $data バリエーション済みのデータ
     * @param array $condition_data 現状のコンディションデータ
     * @return array 整形済みのデータの配列
     */
    public static function formatDataForUserCondition(array $validated_data, array $condition_data): array
    {
        /** @var \App\Models\User $logged_in_user */
        $logged_in_user = Auth::user();

        $formatted_data = [
            ConstParams::USER_CONDITION_ID => $condition_data[ConstParams::USER_CONDITION_ID],
            ConstParams::HAS_ATTENDED => $validated_data[ConstParams::HAS_ATTENDED],
            ConstParams::IS_BREAKING => $validated_data[ConstParams::IS_BREAKING],
            ConstParams::UPDATED_BY => $logged_in_user->getKanjiFullName(),
        ];

        return $formatted_data;
    }
}
