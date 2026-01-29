<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JobApplication extends Model
{
    use HasFactory;

    protected $fillable = [
        'title', 'date_of_birth', 'forename', 'surname', 'previous_name', 'gender', 'marital_status', 'ni_number',
        'address', 'postcode', 'mobile_number', 'landline', 'email',
        'next_of_kin_name', 'next_of_kin_relationship', 'next_of_kin_phone', 'next_of_kin_address', 'next_of_kin_postcode', 'next_of_kin_email',
        'current_job_title', 'current_pay', 'current_duties', 'current_place_of_work', 'current_shift_type',
        'professional_body', 'pin', 'renewal_date', 'pvg_clear', 'pvg_issue_date', 'pvg_number', 'pvg_updated_service',
        'bank_name', 'account_name', 'account_type', 'bank_branch_address', 'bank_postcode', 'account_number', 'sort_code',
        'has_uk_license', 'has_car',
        'work_preferences', 'availability_other', 'start_date', 'interview_availability', 'has_holidays_booked', 'holidays_dates',
        'right_to_work_status',
        'health_declaration', 'disability_declaration', 'confidentiality_declaration', 'photo_consent', 
        'personal_declaration', 'working_time_declaration', 'other_declaration', 'health_safety_declaration',
        'has_convictions', 'convictions_details', 'has_disciplinary', 'disciplinary_details', 
        'has_criminal_charges', 'criminal_charges_details', 'consents_police_check', 
        'police_checked_recently', 'police_check_details',
        'status', 'admin_notes','current_job_title',
        'current_pay_amount',       
        'current_pay_frequency',
        'current_from_date',       
        'current_to_date',
        'profile_photo',
        'registration_certificate_path',
        'character_reference_certificate',
        'right_to_work_share_code',
        'right_to_work_proof_path',
        'current_employer_name',
        'position_applying_for'
    ];

    protected $casts = [
        'date_of_birth' => 'date',
        'renewal_date' => 'date',
        'pvg_issue_date' => 'date',
        'start_date' => 'date',
        'interview_availability' => 'date',
        'pvg_clear' => 'boolean',
        'pvg_updated_service' => 'boolean',
        'has_uk_license' => 'boolean',
        'has_car' => 'boolean',
        'has_holidays_booked' => 'boolean',
        'work_preferences' => 'array',
        'health_declaration' => 'array',
        'disability_declaration' => 'array',
        'confidentiality_declaration' => 'array',
        'photo_consent' => 'array',
        'personal_declaration' => 'array',
        'working_time_declaration' => 'array',
        'other_declaration' => 'array',
        'health_safety_declaration' => 'array',
        'has_convictions' => 'boolean',
        'has_disciplinary' => 'boolean',
        'has_criminal_charges' => 'boolean',
        'consents_police_check' => 'boolean',
        'police_checked_recently' => 'boolean',
        'current_pay' => 'decimal:2',
    ];

    public function workHistories()
    {
        return $this->hasMany(JobApplicationWorkHistory::class)->orderBy('display_order');
    }

    public function educations()
    {
        return $this->hasMany(JobApplicationEducation::class)->orderBy('display_order');
    }

    public function training()
    {
        return $this->hasOne(JobApplicationTraining::class);
    }

    public function immunisation()
    {
        return $this->hasOne(JobApplicationImmunisation::class);
    }

    public function references()
    {
        return $this->hasMany(JobApplicationReference::class)->orderBy('reference_number');
    }

    public function referrals()
    {
        return $this->hasMany(JobApplicationReferral::class)->orderBy('referral_number');
    }
}
