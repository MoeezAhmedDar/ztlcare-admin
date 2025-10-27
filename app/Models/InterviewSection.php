<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InterviewSection extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'display_order',
    ];

    public function questions()
    {
        return $this->hasMany(InterviewQuestion::class, 'section_id')->orderBy('display_order');
    }
}
