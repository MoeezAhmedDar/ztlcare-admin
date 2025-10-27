<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JobApplicationReferral extends Model
{
    use HasFactory;

    protected $table = 'job_application_referrals';

    protected $fillable = [
        'job_application_id',
        'name',
        'telephone',
        'referral_number',
    ];

    public function jobApplication()
    {
        return $this->belongsTo(JobApplication::class);
    }
}
