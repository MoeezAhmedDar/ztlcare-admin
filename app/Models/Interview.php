<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

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
        'public_token',
        'questionnaire_submitted_at',
        'is_questionnaire_complete',
    ];

    protected $casts = [
        'interview_date' => 'date',
        'interviewer_signed_at' => 'datetime',
        'questionnaire_submitted_at' => 'datetime',
        'total_score' => 'integer',
        'is_questionnaire_complete' => 'boolean',
    ];

    protected static function booted()
    {
        static::creating(function ($interview) {
            if (empty($interview->public_token)) {
                $interview->public_token = Str::random(32);
            }
        });
    }

    public function responses()
    {
        return $this->hasMany(InterviewResponse::class);
    }

    public function statusHistories()
    {
        return $this->hasMany(InterviewStatusHistory::class)->latest();
    }

    public function getPublicUrlAttribute()
    {
        return route('interview.public.show', $this->public_token);
    }
}
