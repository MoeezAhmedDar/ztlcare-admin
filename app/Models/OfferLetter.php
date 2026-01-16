<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OfferLetter extends Model
{
    protected $fillable = ['date', 'dear', 'position', 'rate_per_hour', 'custom_offer_details','font_size','to_user_id'];

      protected $casts = [
        'font_size' => 'decimal:2',
    ];

    public function applicant()
    {
        return $this->belongsTo(User::class, 'to_user_id');
    }
}
