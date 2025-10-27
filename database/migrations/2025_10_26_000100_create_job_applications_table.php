<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('job_applications', function (Blueprint $table) {
            $table->id();
            
            // Personal Details
            $table->string('title')->nullable();
            $table->date('date_of_birth')->nullable();
            $table->string('forename');
            $table->string('surname');
            $table->string('previous_name')->nullable();
            $table->string('gender')->nullable();
            $table->string('marital_status')->nullable();
            $table->string('ni_number')->nullable();
            
            // Address
            $table->text('address')->nullable();
            $table->string('postcode')->nullable();
            
            // Contact
            $table->string('mobile_number')->nullable();
            $table->string('landline')->nullable();
            $table->string('email')->nullable();
            
            // Emergency Contact
            $table->string('next_of_kin_name')->nullable();
            $table->string('next_of_kin_relationship')->nullable();
            $table->string('next_of_kin_phone')->nullable();
            $table->text('next_of_kin_address')->nullable();
            $table->string('next_of_kin_postcode')->nullable();
            $table->string('next_of_kin_email')->nullable();
            
            // Current Job
            $table->string('current_job_title')->nullable();
            $table->decimal('current_pay', 10, 2)->nullable();
            $table->text('current_duties')->nullable();
            $table->string('current_place_of_work')->nullable();
            $table->string('current_shift_type')->nullable();
            
            // Professional Memberships
            $table->string('professional_body')->nullable();
            $table->string('pin')->nullable();
            $table->date('renewal_date')->nullable();
            $table->boolean('pvg_clear')->nullable();
            $table->date('pvg_issue_date')->nullable();
            $table->string('pvg_number')->nullable();
            $table->boolean('pvg_updated_service')->nullable();
            
            // Bank Details
            $table->string('bank_name')->nullable();
            $table->string('account_name')->nullable();
            $table->string('account_type')->nullable();
            $table->text('bank_branch_address')->nullable();
            $table->string('bank_postcode')->nullable();
            $table->string('account_number')->nullable();
            $table->string('sort_code')->nullable();
            
            // Driving
            $table->boolean('has_uk_license')->nullable();
            $table->boolean('has_car')->nullable();
            
            // Availability
            $table->json('work_preferences')->nullable();
            $table->string('availability_other')->nullable();
            $table->date('start_date')->nullable();
            $table->date('interview_availability')->nullable();
            $table->boolean('has_holidays_booked')->nullable();
            $table->text('holidays_dates')->nullable();
            
            // Right to Work
            $table->string('right_to_work_status')->nullable();
            
            // Declarations (JSON for signature + date)
            $table->json('health_declaration')->nullable();
            $table->json('disability_declaration')->nullable();
            $table->json('confidentiality_declaration')->nullable();
            $table->json('photo_consent')->nullable();
            $table->json('personal_declaration')->nullable();
            $table->json('working_time_declaration')->nullable();
            $table->json('other_declaration')->nullable();
            $table->json('health_safety_declaration')->nullable();
            
            // Offenders Act
            $table->boolean('has_convictions')->nullable();
            $table->text('convictions_details')->nullable();
            $table->boolean('has_disciplinary')->nullable();
            $table->text('disciplinary_details')->nullable();
            $table->boolean('has_criminal_charges')->nullable();
            $table->text('criminal_charges_details')->nullable();
            $table->boolean('consents_police_check')->nullable();
            $table->boolean('police_checked_recently')->nullable();
            $table->text('police_check_details')->nullable();
            
            // Status tracking
            $table->string('status')->default('pending');
            $table->text('admin_notes')->nullable();
            
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('job_applications');
    }
};
