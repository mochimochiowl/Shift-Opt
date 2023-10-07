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
        Schema::create('user_conditions', function (Blueprint $table) {
            $table->id(ConstParams::USER_CONDITION_ID);
            $table->foreignId(ConstParams::USER_ID)->constrained(
                table: 'users',
                column: ConstParams::USER_ID,
            )->cascadeOnDelete()->cascadeOnUpdate();
            $table->boolean(ConstParams::HAS_ATTENDED)->default(false);
            $table->boolean(ConstParams::IS_BREAKING)->default(false);
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
        Schema::dropIfExists('user_conditions');
    }
};
