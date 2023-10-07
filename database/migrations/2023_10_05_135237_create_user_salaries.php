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
        Schema::create('user_salaries', function (Blueprint $table) {
            $table->id('user_salary_id');
            $table->foreignId('user_id')->constrained(
                table: 'users',
                column: 'user_id',
            )->cascadeOnDelete()->cascadeOnUpdate();
            $table->float('hourly_wage')->default(ConstParams::HOURLY_WAGE_DEFAULT);
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
        Schema::dropIfExists('user_salaries');
    }
};
