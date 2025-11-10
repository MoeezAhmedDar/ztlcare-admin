<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OfferLetter extends Model
{
    protected $fillable = ['date', 'dear', 'position', 'rate_per_hour'];
}
