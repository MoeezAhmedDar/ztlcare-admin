<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('interview_questions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('section_id')->constrained('interview_sections')->cascadeOnDelete();
            $table->string('prompt');
            $table->string('input_type')->default('text');
            $table->json('options')->nullable();
            $table->boolean('has_score')->default(false);
            $table->unsignedInteger('display_order')->default(0);
            $table->text('help_text')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('interview_questions');
    }
};
