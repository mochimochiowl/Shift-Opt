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
        Schema::create('attendance_records', function (Blueprint $table) {
            $table->id('at_record_id');
            $table->foreignId('user_id')->constrained(
                table: 'users',
                column: 'user_id',
            )->cascadeOnDelete()->cascadeOnUpdate();
            $table->string('at_record_type');
            $table->timestamp('at_record_time');
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
        Schema::dropIfExists('attendance_records');
    }
};
