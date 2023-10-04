<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id('user_id');
            $table->string('kanji_last_name', NAME_CHAR_LIMIT);
            $table->string('kanji_first_name', NAME_CHAR_LIMIT);
            $table->string('kana_last_name', NAME_CHAR_LIMIT);
            $table->string('kana_first_name', NAME_CHAR_LIMIT);
            $table->string('email', EMAIL_CHAR_LIMIT);
            $table->string('login_id', LOGIN_ID_CHAR_LIMIT)->unique();
            $table->string('password', PASSWORD_CHAR_LIMIT);
            $table->rememberToken();
            $table->timestamps();
            $table->string('created_by', NAME_CHAR_LIMIT * 2)->default(BY_NAME_DEFAULT);
            $table->string('updated_by', NAME_CHAR_LIMIT * 2)->default(BY_NAME_DEFAULT);
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
