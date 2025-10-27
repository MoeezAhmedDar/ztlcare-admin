<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Interview extends Model
{
    use HasFactory;

    protected $fillable = [
        'recruiter_name',
        'interview_date',
        'candidate_name',
        'location',
        'outcome',
        'status',
        'notes',
        'overall_feedback',
        'total_score',
        'position_offered',
        'recruitment_authorization',
        'interviewer_signature_name',
        'interviewer_signed_at',
    ];

    protected $casts = [
        'interview_date' => 'date',
        'interviewer_signed_at' => 'datetime',
        'total_score' => 'integer',
    ];

    public function responses()
    {
        return $this->hasMany(InterviewResponse::class);
    }

    public function statusHistories()
    {
        return $this->hasMany(InterviewStatusHistory::class)->latest();
    }
}
