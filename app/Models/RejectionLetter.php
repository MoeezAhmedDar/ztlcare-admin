<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RejectionLetter extends Model
{
    protected $fillable = ['date', 'dear', 'position','custom_rejection_message','font_size','to_user_id'];

    protected $casts = [
        'font_size' => 'decimal:2',
    ];

    public function applicant()
    {
        return $this->belongsTo(User::class, 'to_user_id');
    }
}
