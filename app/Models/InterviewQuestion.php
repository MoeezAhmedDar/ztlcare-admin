<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InterviewQuestion extends Model
{
    use HasFactory;

    protected $fillable = [
        'section_id',
        'prompt',
        'input_type',
        'options',
        'has_score',
        'display_order',
        'help_text',
    ];

    protected $casts = [
        'options' => 'array',
        'has_score' => 'boolean',
    ];

    public function section()
    {
        return $this->belongsTo(InterviewSection::class, 'section_id');
    }

    public function responses()
    {
        return $this->hasMany(InterviewResponse::class, 'question_id');
    }
}
