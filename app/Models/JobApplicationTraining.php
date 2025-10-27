<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JobApplicationTraining extends Model
{
    use HasFactory;

    protected $table = 'job_application_training';

    protected $fillable = [
        'job_application_id',
        'mandatory_training',
        'other_training',
    ];

    protected $casts = [
        'mandatory_training' => 'array',
    ];

    public function jobApplication()
    {
        return $this->belongsTo(JobApplication::class);
    }
}
