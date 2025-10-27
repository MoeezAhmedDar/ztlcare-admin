<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InterviewStatusHistory extends Model
{
    use HasFactory;

    protected $fillable = [
        'interview_id',
        'status',
        'comment',
    ];

    public function interview()
    {
        return $this->belongsTo(Interview::class);
    }
}
