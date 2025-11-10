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
        Schema::create('invite_letters', function (Blueprint $table) {
            $table->id();
            $table->string('date');
            $table->string('to_name');
            $table->string('dear');
            $table->string('position');
            $table->string('time');
            $table->string('interview_date');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('invite_letters');
    }
};
