<?php

namespace Database\Seeders;

use App\Const\ConstParams;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AdminUserSeeder extends Seeder
{
    /**
     * 管理者ユーザーを作成
     */
    public function run(): void
    {
        // 管理者ユーザーの作成
        User::create([
            ConstParams::KANJI_LAST_NAME => '管理者',
            ConstParams::KANJI_FIRST_NAME => 'ユーザー',
            ConstParams::KANA_LAST_NAME => 'カンリシャ',
            ConstParams::KANA_FIRST_NAME => 'ユーザー',
            ConstParams::EMAIL => 'admin@fakeEmailAddress.jp',
            ConstParams::LOGIN_ID => 'admin',
            ConstParams::PASSWORD => 'shiftOpt',
            ConstParams::CREATED_BY => '新規登録',
            ConstParams::UPDATED_BY => '新規登録',
        ]);
    }
}
