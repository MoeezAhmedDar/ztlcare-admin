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
            // Current job start and end dates
            $table->date('current_from_date')->nullable()->after('current_shift_type');
            $table->date('current_to_date')->nullable()->after('current_from_date');

            // Replace old current_pay with amount + frequency
            $table->decimal('current_pay_amount', 8, 2)->nullable()->after('current_job_title');
            $table->enum('current_pay_frequency', ['hour', 'week', 'month','year'])->nullable()->after('current_pay_amount');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('job_applications', function (Blueprint $table) {
            $table->dropColumn([
                'current_from_date',
                'current_to_date',
                'current_pay_amount',
                'current_pay_frequency',
            ]);
        });
    }
};
