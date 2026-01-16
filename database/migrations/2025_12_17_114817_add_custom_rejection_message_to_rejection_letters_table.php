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
        Schema::table('rejection_letters', function (Blueprint $table) {
            $table->longText('custom_rejection_message')
                  ->nullable()
                  ->after('position');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('rejection_letters', function (Blueprint $table) {
            $table->dropColumn('custom_rejection_message');
        });
    }
};
