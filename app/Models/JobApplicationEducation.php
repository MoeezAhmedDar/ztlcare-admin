<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JobApplicationEducation extends Model
{
    use HasFactory;

    protected $table = 'job_application_educations';

    protected $fillable = [
        'job_application_id',
        'establishment',
        'from_date',
        'to_date',
        'qualification',
        'grade',
        'display_order',
    ];

    public function jobApplication()
    {
        return $this->belongsTo(JobApplication::class);
    }
}
