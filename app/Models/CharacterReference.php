<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CharacterReference extends Model
{
    protected $fillable = ['date', 'dear', 'candidate_name', 'position','custom_body','font_size','to_user_id'];

     protected $casts = [
        'font_size' => 'decimal:2',
    ];

    public function applicant()
    {
        return $this->belongsTo(User::class, 'to_user_id');
    }

}
