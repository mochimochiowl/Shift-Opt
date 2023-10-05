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
        Schema::create('user_conditions', function (Blueprint $table) {
            $table->id('user_condition_id');
            $table->foreignId('user_id')->constrained(
                table: 'users',
                column: 'user_id',
            )->cascadeOnDelete()->cascadeOnUpdate();
            $table->boolean('has_attended')->default(false);
            $table->boolean('is_breaking')->default(false);
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
        Schema::dropIfExists('user_conditions');
    }
};
