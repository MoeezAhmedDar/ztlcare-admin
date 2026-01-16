<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InviteLetter extends Model
{
   // app/Models/InviteLetter.php
    protected $fillable = [
        'date', 'to_name', 'dear', 'position', 'time', 'interview_date', 'custom_documents','font_size','to_user_id'
    ];

    protected $casts = [
        'font_size' => 'decimal:2',
    ];

    public function applicant()
    {
        return $this->belongsTo(User::class, 'to_user_id');
    }
}
