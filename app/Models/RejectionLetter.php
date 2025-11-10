<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RejectionLetter extends Model
{
    protected $fillable = ['date', 'dear', 'position'];
}
