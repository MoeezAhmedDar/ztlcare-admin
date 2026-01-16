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
        Schema::table('invite_letters', function (Blueprint $table) {
            $table->decimal('font_size', 4, 2)->default(10.00)->after('position'); // default 10pt

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('invite_letters', function (Blueprint $table) {
            $table->dropColumn('font_size');
        });
    }
};
