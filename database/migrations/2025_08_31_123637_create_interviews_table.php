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
        Schema::create('interviews', function (Blueprint $table) {
    $table->id();
    $table->string('question')->comment('Question is required');
    $table->string('answer')->comment('Answer is required');
    $table->enum('difficultyLevel', ['easy', 'medium', 'hard'])->comment('Difficulty Level is required');
    $table->integer('categoryId')->comment('Category Id is required');
    $table->timestamps();
});

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('interviews');
    }
};
