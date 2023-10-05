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
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('id');
            $table->dropColumn('email');
            $table->dropColumn('password');
            $table->dropColumn('email_verified_at');
            $table->dropColumn('remember_token');
            $table->dropColumn('created_at');
            $table->dropColumn('updated_at');

            $table->id('user_id');
            $table->string('kanji_last_name', NAME_CHAR_LIMIT);
            $table->string('kanji_first_name', NAME_CHAR_LIMIT);
            $table->string('kana_last_name', NAME_CHAR_LIMIT);
            $table->string('kana_first_name', NAME_CHAR_LIMIT);
            $table->string('email', EMAIL_CHAR_LIMIT)->unique();
            $table->string('login_id', LOGIN_ID_CHAR_LIMIT)->unique();
            $table->string('password');
            $table->rememberToken();
            $table->string('created_by', NAME_CHAR_LIMIT * 2)->default(BY_NAME_DEFAULT);
            $table->string('updated_by', NAME_CHAR_LIMIT * 2)->default(BY_NAME_DEFAULT);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            //
        });
    }
};
