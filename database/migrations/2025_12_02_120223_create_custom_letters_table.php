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
        Schema::create('custom_letters', function (Blueprint $table) {
            $table->id();
            $table->boolean('show_date')->default(true);
            $table->date('date')->nullable();
            $table->enum('greeting_type', ['dear', 'to_whom'])->default('dear');
            $table->string('dear_name')->nullable();
            $table->longText('body_content'); // HTML content
            $table->string('title')->nullable(); // optional title like "Reference Letter"
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('custom_letters');
    }
};
