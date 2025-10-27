<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InterviewResponse extends Model
{
    use HasFactory;

    protected $fillable = [
        'interview_id',
        'question_id',
        'answer',
        'score',
    ];

    protected $casts = [
        'score' => 'integer',
    ];

    public function interview()
    {
        return $this->belongsTo(Interview::class);
    }

    public function question()
    {
        return $this->belongsTo(InterviewQuestion::class, 'question_id');
    }
}
