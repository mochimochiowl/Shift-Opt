<?php

use App\Const\ConstParams;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * ユーザーテーブルの定義
 * @author mochimochiowl
 * @version 1.0.0
 */
return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id(ConstParams::USER_ID)->index();
            $table->string(ConstParams::KANJI_LAST_NAME, ConstParams::NAME_CHAR_LIMIT);
            $table->string(ConstParams::KANJI_FIRST_NAME, ConstParams::NAME_CHAR_LIMIT);
            $table->string(ConstParams::KANA_LAST_NAME, ConstParams::NAME_CHAR_LIMIT);
            $table->string(ConstParams::KANA_FIRST_NAME, ConstParams::NAME_CHAR_LIMIT);
            $table->string(ConstParams::EMAIL, ConstParams::EMAIL_CHAR_LIMIT)->unique();
            $table->timestamp(ConstParams::EMAIL_VERIFIED_AT)->nullable();
            $table->string(ConstParams::LOGIN_ID, ConstParams::LOGIN_ID_CHAR_LIMIT)->unique();
            $table->string(ConstParams::PASSWORD);
            $table->boolean(ConstParams::IS_ADMIN);
            $table->rememberToken();
            $table->string(ConstParams::CREATED_BY, ConstParams::NAME_CHAR_LIMIT * 2)->default(ConstParams::BY_NAME_DEFAULT);
            $table->string(ConstParams::UPDATED_BY, ConstParams::NAME_CHAR_LIMIT * 2)->default(ConstParams::BY_NAME_DEFAULT);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
