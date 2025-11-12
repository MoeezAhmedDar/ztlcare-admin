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
        Schema::create('reference_requests', function (Blueprint $table) {
            $table->id();
            $table->string('surname');
            $table->string('forename');
            $table->string('position');
            $table->text('home_address')->nullable();
            $table->string('start_date')->nullable();
            $table->string('leaving_date')->nullable();
            $table->string('job_title')->nullable();
            $table->text('capacity')->nullable();
            $table->text('reason_leaving')->nullable();
            $table->string('gross_salary')->nullable();
            $table->text('duties')->nullable();
            $table->text('ability_role')->nullable();
            $table->text('time_management')->nullable();
            $table->text('reliability')->nullable();
            $table->text('disciplinary')->nullable();
            $table->text('reemploy')->nullable();
            $table->text('criminal')->nullable();
            $table->text('other_info')->nullable();
            $table->string('ref_position')->nullable();
            $table->string('ref_date')->nullable();
            $table->text('ref_signed')->nullable();
            $table->string('ref_name')->nullable();
            $table->text('ref_company')->nullable();
            $table->string('office_verified')->nullable();
            $table->text('office_signed')->nullable();
            $table->string('office_name')->nullable();
            $table->string('office_position')->nullable();
            $table->string('office_date')->nullable();
            $table->text('office_comments')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reference_requests');
    }
};
