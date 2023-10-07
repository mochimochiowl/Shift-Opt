<?php

use App\Const\ConstParams;
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
            $table->string('kanji_last_name', ConstParams::NAME_CHAR_LIMIT);
            $table->string('kanji_first_name', ConstParams::NAME_CHAR_LIMIT);
            $table->string('kana_last_name', ConstParams::NAME_CHAR_LIMIT);
            $table->string('kana_first_name', ConstParams::NAME_CHAR_LIMIT);
            $table->string('email', ConstParams::EMAIL_CHAR_LIMIT)->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('login_id', ConstParams::LOGIN_ID_CHAR_LIMIT)->unique();
            $table->string('password');
            $table->rememberToken();
            $table->string('created_by', ConstParams::NAME_CHAR_LIMIT * 2)->default(ConstParams::BY_NAME_DEFAULT);
            $table->string('updated_by', ConstParams::NAME_CHAR_LIMIT * 2)->default(ConstParams::BY_NAME_DEFAULT);
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
