<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JobApplicationWorkHistory extends Model
{
    use HasFactory;

    protected $table = 'job_application_work_histories';

    protected $fillable = [
        'job_application_id',
        'from_date',
        'to_date',
        'employer_name',
        'job_title',
        'main_responsibilities',
        'employer_address',
        'reason_for_leaving',
        'display_order',
    ];

    protected $casts = [
        'from_date' => 'date',
        'to_date' => 'date',
    ];

    public function jobApplication()
    {
        return $this->belongsTo(JobApplication::class);
    }
}
