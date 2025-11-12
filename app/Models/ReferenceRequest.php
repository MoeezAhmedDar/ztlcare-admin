<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ReferenceRequest extends Model
{
    protected $fillable = [
        'surname', 'forename', 'position', 'home_address', 'start_date', 'leaving_date',
        'job_title', 'capacity', 'reason_leaving', 'gross_salary', 'duties', 'ability_role',
        'time_management', 'reliability', 'disciplinary', 'reemploy', 'criminal', 'other_info',
        'ref_position', 'ref_date', 'ref_signed', 'ref_name', 'ref_company',
        'office_verified', 'office_signed', 'office_name', 'office_position', 'office_date', 'office_comments'
    ];
}
