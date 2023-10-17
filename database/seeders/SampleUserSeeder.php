<?php

namespace Database\Seeders;

use App\Const\ConstParams;
use App\Models\User;
use App\Models\UserCondition;
use App\Models\UserSalary;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SampleUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $infos = [
            [ConstParams::KANJI_LAST_NAME => '佐藤', ConstParams::KANJI_FIRST_NAME => '太郎', ConstParams::KANA_LAST_NAME => 'サトウ', ConstParams::KANA_FIRST_NAME => 'タロウ', ConstParams::LOGIN_ID => 'SatoTaro'],
            [ConstParams::KANJI_LAST_NAME => '鈴木', ConstParams::KANJI_FIRST_NAME => '花子', ConstParams::KANA_LAST_NAME => 'スズキ', ConstParams::KANA_FIRST_NAME => 'ハナコ', ConstParams::LOGIN_ID => 'SuzukiHanako'],
            [ConstParams::KANJI_LAST_NAME => '高橋', ConstParams::KANJI_FIRST_NAME => '一郎', ConstParams::KANA_LAST_NAME => 'タカハシ', ConstParams::KANA_FIRST_NAME => 'イチロウ', ConstParams::LOGIN_ID => 'TakahashiIchiro'],
            [ConstParams::KANJI_LAST_NAME => '田中', ConstParams::KANJI_FIRST_NAME => '明日香', ConstParams::KANA_LAST_NAME => 'タナカ', ConstParams::KANA_FIRST_NAME => 'アスカ', ConstParams::LOGIN_ID => 'TanakaAsuka'],
            [ConstParams::KANJI_LAST_NAME => '山田', ConstParams::KANJI_FIRST_NAME => '直樹', ConstParams::KANA_LAST_NAME => 'ヤマダ', ConstParams::KANA_FIRST_NAME => 'ナオキ', ConstParams::LOGIN_ID => 'YamadaNaoki'],
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
                ConstParams::CREATED_BY => 'サンプルデータとして初期登録',
                ConstParams::UPDATED_BY => 'サンプルデータとして初期登録',
            ];
            $this->create($data);
        }
    }

    /**
     * ユーザー＋関連レコードの作成
     * @return void
     */
    private function create($data): void
    {
        $user = User::createNewUser($data);
        UserSalary::createForUser($user);
        UserCondition::createForUser($user);
    }
}
