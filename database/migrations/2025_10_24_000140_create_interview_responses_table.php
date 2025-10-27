<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('interview_responses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('interview_id')->constrained('interviews')->cascadeOnDelete();
            $table->foreignId('question_id')->constrained('interview_questions')->cascadeOnDelete();
            $table->text('answer')->nullable();
            $table->unsignedTinyInteger('score')->nullable();
            $table->timestamps();

            $table->unique(['interview_id', 'question_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('interview_responses');
    }
};
