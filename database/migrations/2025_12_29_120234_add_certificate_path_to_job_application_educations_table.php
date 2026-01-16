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
        Schema::table('job_application_educations', function (Blueprint $table) {
            $table->string('certificate_path')->nullable()->after('grade');
            // Optional: add an index if you plan to query by certificate path frequently
            $table->index('certificate_path');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('job_application_educations', function (Blueprint $table) {
            $table->dropColumn('certificate_path');
        });
    }
};
