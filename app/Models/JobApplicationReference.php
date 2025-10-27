<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JobApplicationReference extends Model
{
    use HasFactory;

    protected $table = 'job_application_references';

    protected $fillable = [
        'job_application_id',
        'name',
        'position',
        'company_address',
        'telephone',
        'email',
        'may_contact_now',
        'reference_number',
    ];

    protected $casts = [
        'may_contact_now' => 'boolean',
    ];

    public function jobApplication()
    {
        return $this->belongsTo(JobApplication::class);
    }
}
