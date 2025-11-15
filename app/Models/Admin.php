<?php

namespace App\Models;

use App\Traits\MorphFile;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Tymon\JWTAuth\Contracts\JWTSubject; // <-- ADD THIS

class Admin extends Authenticatable implements JWTSubject // <-- IMPLEMENT INTERFACE
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles, MorphFile;

    protected $fillable = [
        'name',
        'email',
        'phone',
        'type',
        'messanger_id',
        'whatsapp',
        'password',
        'isActive',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];
 protected $guard_name = 'admin'; // 🔥 Add this
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function getImageAttribute()
    {
        return $this->file ? asset($this->file->url) : settings()->logo;
    }

    public function tasks()
    {
        return $this->hasMany(Task::class, 'admin_id');
    }

    // ✅ ADD THESE METHODS REQUIRED BY JWTSubject

    public function getJWTIdentifier()
    {
        return $this->getKey(); // usually 'id'
    }

    public function getJWTCustomClaims()
    {
        return [];
    }

}
