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
        Schema::create('attendance_records', function (Blueprint $table) {
            $table->id(ConstParams::AT_RECORD_ID);
            $table->string(ConstParams::AT_SESSION_ID)->unique();
            $table->foreignId(ConstParams::USER_ID)->constrained(
                table: 'users',
                column: ConstParams::USER_ID,
            )->cascadeOnDelete()->cascadeOnUpdate();
            $table->string(ConstParams::AT_RECORD_TYPE);
            $table->date(ConstParams::AT_RECORD_DATE);
            $table->time(ConstParams::AT_RECORD_TIME);
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
        Schema::dropIfExists('attendance_records');
    }
};
