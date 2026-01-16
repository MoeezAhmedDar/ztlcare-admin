<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CustomLetter extends Model
{
    // app/Models/CustomLetter.php
    protected $fillable = [
        'title', 'show_date', 'date', 'greeting_type', 'dear_name', 'body_content','font_size','to_user_id'
    ];
    protected $casts = [
        'show_date' => 'boolean',
        'date'      => 'date',
        'font_size' => 'decimal:2',
    ];

    public function applicant()
    {
        return $this->belongsTo(User::class, 'to_user_id');
    }
}