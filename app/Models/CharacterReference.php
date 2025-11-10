<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CharacterReference extends Model
{
    protected $fillable = ['date', 'dear', 'candidate_name', 'position'];
}
