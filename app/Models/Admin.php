<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;
use Tymon\JWTAuth\Contracts\JWTSubject;
use App\Traits\MorphFile;

class Admin extends Authenticatable implements JWTSubject
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles, MorphFile;

    public $guard_name = 'admin';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'phone',
        'whatsapp',
        'messanger_id',
        'type',
        'isActive',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'isActive' => 'boolean',
    ];

    /**
     * Get roles for this admin.
     */
    public function getRoles()
    {
        return $this->roles()->pluck('name')->toArray();
    }

    /**
     * Get direct permissions for this admin.
     */
    public function getDirectPermissions()
    {
        return $this->permissions()->pluck('name')->toArray();
    }

    /**
     * Get all permissions (direct + role-based).
     */
    public function getAllPermissions()
    {
        // Get direct permissions
        $directPermissions = $this->getDirectPermissions();
        
        // Get permissions through roles
        $rolePermissions = [];
        foreach ($this->roles as $role) {
            $rolePermissions = array_merge(
                $rolePermissions,
                $role->permissions()->pluck('name')->toArray()
            );
        }
        
        // Merge and remove duplicates
        $allPermissions = array_unique(array_merge($directPermissions, $rolePermissions));
        
        return array_values($allPermissions);
    }

    /**
     * Scope to include roles and permissions.
     */
    public function scopeWithRolesAndPermissions($query)
    {
        return $query->with(['roles.permissions', 'permissions']);
    }

    /**
     * Get the identifier that will be stored in the JWT subject claim.
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return a key value array containing any custom claims.
     */
    public function getJWTCustomClaims()
    {
        return [];
    }
}
