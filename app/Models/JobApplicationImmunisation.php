<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JobApplicationImmunisation extends Model
{
    use HasFactory;

    protected $table = 'job_application_immunisations';

    protected $fillable = [
        'job_application_id',
        'hep_b',
        'tb',
        'varicella',
        'measles',
        'rubella',
        'hep_b_antigen',
        'hep_c',
        'hiv',
    ];

    protected $casts = [
        'hep_b' => 'boolean',
        'tb' => 'boolean',
        'varicella' => 'boolean',
        'measles' => 'boolean',
        'rubella' => 'boolean',
    ];

    public function jobApplication()
    {
        return $this->belongsTo(JobApplication::class);
    }
}
