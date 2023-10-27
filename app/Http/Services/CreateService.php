<?php

namespace App\Http\Services;

use App\Const\ConstParams;
use Illuminate\Support\Facades\Auth;

/**
 * ユーザーの更新に関連するビジネスロジックを管轄する
 * @author mochimochiowl
 * @version 1.0.0
 */
class CreateService
{
    /**
     * 打刻レコードの作成に必要なデータを整形する
     * @param int $user_id 打刻者のID
     * @param string $name 更新者の名前
     * @param array $data バリエーション済みのデータ
     * @return array 整形済みのデータの配列
     */
    public static function formatDataForAtRecord(int $user_id, string $name, array $data): array
    {
        $formatted_data = [
            'target_user_id' => $user_id,
            ConstParams::AT_SESSION_ID => $data[ConstParams::AT_SESSION_ID],
            ConstParams::AT_RECORD_TYPE => $data[ConstParams::AT_RECORD_TYPE],
            ConstParams::AT_RECORD_DATE => $data[ConstParams::AT_RECORD_DATE],
            ConstParams::AT_RECORD_TIME => $data[ConstParams::AT_RECORD_TIME],
            ConstParams::CREATED_BY => $name,
        ];

        return $formatted_data;
    }
}
