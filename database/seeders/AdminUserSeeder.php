<?php

namespace Database\Seeders;

use App\Const\ConstParams;
use App\Models\User;
use App\Models\UserCondition;
use App\Models\UserSalary;
use Illuminate\Database\Seeder;

/**
 * 管理者ユーザーとして、userデータ(user_salaryやuser_conditionを含む)をシーディング
 */
class AdminUserSeeder extends Seeder
{
    /**
     * シーディング実行
     * @return void
     */
    public function run(): void
    {
        $data = [
            ConstParams::KANJI_LAST_NAME => '管理者',
            ConstParams::KANJI_FIRST_NAME => 'ユーザー',
            ConstParams::KANA_LAST_NAME => 'カンリシャ',
            ConstParams::KANA_FIRST_NAME => 'ユーザー',
            ConstParams::EMAIL => 'admin@fakeEmailAddress.jp',
            ConstParams::LOGIN_ID => 'admin',
            ConstParams::PASSWORD => 'shiftOpt',
            ConstParams::CREATED_BY => '新規登録',
            ConstParams::UPDATED_BY => '新規登録',
        ];
        $user = User::createNewUser($data);
        UserSalary::createForUser($user);
        UserCondition::createForUser($user);
    }
}
