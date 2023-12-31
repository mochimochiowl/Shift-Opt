<?php

namespace Database\Seeders;

use App\Const\ConstParams;
use App\Models\User;
use App\Models\UserCondition;
use App\Models\UserSalary;
use Illuminate\Database\Seeder;

/**
 * サンプルのユーザーを追加する
 * @author mochimochiowl
 * @version 1.0.0
 */
class SampleUserSeeder extends Seeder
{
    /**
     * シーディング実行
     * @return void
     */
    public function run(): void
    {
        $infos = [
            [ConstParams::KANJI_LAST_NAME => '河合', ConstParams::KANJI_FIRST_NAME => '有栖 (ｻﾝﾌﾟﾙ)', ConstParams::KANA_LAST_NAME => 'カワイ', ConstParams::KANA_FIRST_NAME => 'アリス (ｻﾝﾌﾟﾙ)', ConstParams::LOGIN_ID => 'KawaiArisu', ConstParams::HOURLY_WAGE => 1000.00],
            [ConstParams::KANJI_LAST_NAME => '鈴木', ConstParams::KANJI_FIRST_NAME => '花子 (ｻﾝﾌﾟﾙ)', ConstParams::KANA_LAST_NAME => 'スズキ', ConstParams::KANA_FIRST_NAME => 'ハナコ (ｻﾝﾌﾟﾙ)', ConstParams::LOGIN_ID => 'SuzukiHanako', ConstParams::HOURLY_WAGE => 950.00],
            [ConstParams::KANJI_LAST_NAME => '高橋', ConstParams::KANJI_FIRST_NAME => '洋平 (ｻﾝﾌﾟﾙ)', ConstParams::KANA_LAST_NAME => 'タカハシ', ConstParams::KANA_FIRST_NAME => 'ヨウヘイ (ｻﾝﾌﾟﾙ)', ConstParams::LOGIN_ID => 'TakahashiYohei', ConstParams::HOURLY_WAGE => 1030.00],
            [ConstParams::KANJI_LAST_NAME => '田中', ConstParams::KANJI_FIRST_NAME => '明日香 (ｻﾝﾌﾟﾙ)', ConstParams::KANA_LAST_NAME => 'タナカ', ConstParams::KANA_FIRST_NAME => 'アスカ (ｻﾝﾌﾟﾙ)', ConstParams::LOGIN_ID => 'TanakaAsuka', ConstParams::HOURLY_WAGE => 1200.00],
            [ConstParams::KANJI_LAST_NAME => '山田', ConstParams::KANJI_FIRST_NAME => '直樹 (ｻﾝﾌﾟﾙ)', ConstParams::KANA_LAST_NAME => 'ヤマダ', ConstParams::KANA_FIRST_NAME => 'ナオキ (ｻﾝﾌﾟﾙ)', ConstParams::LOGIN_ID => 'YamadaNaoki', ConstParams::HOURLY_WAGE => 980.00],
        ];

        foreach ($infos as $info) {
            $data = [
                ConstParams::KANJI_LAST_NAME => $info[ConstParams::KANJI_LAST_NAME],
                ConstParams::KANJI_FIRST_NAME => $info[ConstParams::KANJI_FIRST_NAME],
                ConstParams::KANA_LAST_NAME => $info[ConstParams::KANA_LAST_NAME],
                ConstParams::KANA_FIRST_NAME => $info[ConstParams::KANA_FIRST_NAME],
                ConstParams::EMAIL => $info[ConstParams::LOGIN_ID] . '@fakeEmailAddress.jp',
                ConstParams::LOGIN_ID => $info[ConstParams::LOGIN_ID],
                ConstParams::PASSWORD => 'samplePassword',
                ConstParams::IS_ADMIN => false,
                ConstParams::CREATED_BY => 'サンプルデータとして初期登録',
                ConstParams::UPDATED_BY => 'サンプルデータとして初期登録',
            ];
            $this->create($data, $info[ConstParams::HOURLY_WAGE]);
        }
    }

    /**
     * ユーザー＋関連レコードの作成
     * @return void
     */
    private function create(array $data, float $hourly_wage): void
    {
        $user = User::createNewUser($data);
        $salary = UserSalary::createForUser($user);
        $salary->hourly_wage = $hourly_wage;
        $salary->save();
        UserCondition::createForUser($user);
    }
}
