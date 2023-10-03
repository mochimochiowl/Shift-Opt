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
        Schema::create('staffs', function (Blueprint $table) {
            $name_length = 30;

            $table->id('staff_id');
            $table->string('staff_kanji_name', $name_length);
            $table->string('staff_kana_name', $name_length);
            $table->float('hourly_wage');
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
        Schema::dropIfExists('staffs');
    }
};
