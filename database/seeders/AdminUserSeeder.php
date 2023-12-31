<?php

namespace Database\Seeders;

use App\Const\ConstParams;
use App\Models\User;
use App\Models\UserCondition;
use App\Models\UserSalary;
use Illuminate\Database\Seeder;

/**
 * 管理者ユーザーとシステムユーザーを追加する
 * @author mochimochiowl
 * @version 1.0.0
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
            ConstParams::IS_ADMIN => 'true',
            ConstParams::CREATED_BY => '新規登録',
            ConstParams::UPDATED_BY => '新規登録',
        ];
        $user = User::createNewUser($data);
        UserSalary::createForUser($user);
        UserCondition::createForUser($user);

        $data = [
            ConstParams::KANJI_LAST_NAME => 'システム',
            ConstParams::KANJI_FIRST_NAME => 'ユーザー',
            ConstParams::KANA_LAST_NAME => 'システム',
            ConstParams::KANA_FIRST_NAME => 'ユーザー',
            ConstParams::EMAIL => 'systemadmin@fakeEmailAddress.jp',
            ConstParams::LOGIN_ID => 'system',
            ConstParams::PASSWORD => 'shiftOpt',
            ConstParams::IS_ADMIN => 'true',
            ConstParams::CREATED_BY => '新規登録',
            ConstParams::UPDATED_BY => '新規登録',
        ];
        $user = User::createNewUser($data);
        UserSalary::createForUser($user);
        UserCondition::createForUser($user);

        $data = [
            ConstParams::KANJI_LAST_NAME => '見学',
            ConstParams::KANJI_FIRST_NAME => 'ユーザー',
            ConstParams::KANA_LAST_NAME => '見学',
            ConstParams::KANA_FIRST_NAME => 'ユーザー',
            ConstParams::EMAIL => 'kenngaku01@fakeEmailAddress.jp',
            ConstParams::LOGIN_ID => 'kenngaku01',
            ConstParams::PASSWORD => 'shiftOpt',
            ConstParams::IS_ADMIN => 'true',
            ConstParams::CREATED_BY => '新規登録',
            ConstParams::UPDATED_BY => '新規登録',
        ];
        $user = User::createNewUser($data);
        UserSalary::createForUser($user);
        UserCondition::createForUser($user);

        // DB::statement('ALTER SEQUENCE users_user_id_seq RESTART WITH 1;');
    }
}
