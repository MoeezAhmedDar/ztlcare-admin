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
        Schema::table('job_applications', function (Blueprint $table) {
            $table->string('right_to_work_share_code')->nullable()->after('right_to_work_status');
            $table->string('right_to_work_proof_path')->nullable()->after('right_to_work_share_code');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('job_applications', function (Blueprint $table) {
            $table->dropColumn(['right_to_work_share_code', 'right_to_work_proof_path']);
        });
    }
};
