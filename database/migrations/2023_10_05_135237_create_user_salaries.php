<?php

use App\Const\ConstParams;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * 時給データテーブルの定義
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
        Schema::create('user_salaries', function (Blueprint $table) {
            $table->id(ConstParams::USER_SALARY_ID);
            $table->foreignId(ConstParams::USER_ID)->constrained(
                table: 'users',
                column: ConstParams::USER_ID,
            )->cascadeOnDelete()->cascadeOnUpdate();
            $table->decimal(ConstParams::HOURLY_WAGE, 8, 2, true)->default(ConstParams::HOURLY_WAGE_DEFAULT);
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
        Schema::dropIfExists('user_salaries');
    }
};
