<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('interviews', function (Blueprint $table) {
            $table->id();
            $table->string('recruiter_name')->nullable();
            $table->date('interview_date')->nullable();
            $table->string('candidate_name');
            $table->string('location')->nullable();
            $table->string('outcome')->default('pending');
            $table->string('status')->default('draft');
            $table->text('notes')->nullable();
            $table->text('overall_feedback')->nullable();
            $table->unsignedSmallInteger('total_score')->nullable();
            $table->string('position_offered')->nullable();
            $table->string('recruitment_authorization')->nullable();
            $table->string('interviewer_signature_name')->nullable();
            $table->timestamp('interviewer_signed_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('interviews');
    }
};
