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
            $name_length = 30;

            $table->id('at_record_id');
            $table->foreignId('staff_id')->constrained(
                table: 'staffs',
                column: 'staff_id',
            )->cascadeOnDelete()->cascadeOnUpdate();
            $table->integer('at_record_type');
            $table->timestamp('time');
            $table->timestamps();
            $table->string('created_by', $name_length)->default('初回登録');
            $table->string('updated_by', $name_length)->default('初回登録');
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
