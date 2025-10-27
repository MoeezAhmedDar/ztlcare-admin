<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('job_application_immunisations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('job_application_id')->constrained()->cascadeOnDelete();
            $table->boolean('hep_b')->nullable();
            $table->boolean('tb')->nullable();
            $table->boolean('varicella')->nullable();
            $table->boolean('measles')->nullable();
            $table->boolean('rubella')->nullable();
            $table->string('hep_b_antigen')->nullable();
            $table->string('hep_c')->nullable();
            $table->string('hiv')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('job_application_immunisations');
    }
};
