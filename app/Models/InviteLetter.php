<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InviteLetter extends Model
{
    protected $fillable = [
        'date', 'to_name', 'dear', 'position', 'time', 'interview_date'
    ];
}
