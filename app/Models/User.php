<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'first_name',
        'middle_name',
        'last_name',
        'email',
        'password',
        'phone',
        'postcode',
        'dob',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */

    protected static function booted()
    {
        static::deleting(function (User $user) {
            $user->roles()->detach();
            $user->permissions()->detach();
            
            // Optional: also revoke tokens if using Sanctum/Passport
            // $user->tokens()->delete();
        });
    }


    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'dob' => 'date', // Optional: cast to Carbon date
        ];
    }

    /**
     * Get the user's full name (accessor).
     *
     * @return string
     */
    public function getFullNameAttribute(): string
    {
        $parts = [$this->first_name];
        if ($this->middle_name) {
            $parts[] = $this->middle_name;
        }
        $parts[] = $this->last_name;

        return trim(implode(' ', $parts));
    }
}