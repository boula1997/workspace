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

    // Owner role: admins holding it count as boula(). Can be picked as a role in the admin forms.
    public const SUPER_ADMIN_ROLE = 'Super Admin';

    public function isSuperAdmin(): bool
    {
        return $this->hasRole(self::SUPER_ADMIN_ROLE, 'admin');
    }

    /**
     * Applies the role picked in an admin form (Blade, API or the generic dashboard table).
     *
     * Super Admin carries no permissions of its own, so picking it is added on top of the admin's
     * current roles (they keep their normal permissions). Picking any other role makes that the
     * admin's only role, which also takes Super Admin away.
     */
    public function applyRole(string $role): void
    {
        if ($role !== self::SUPER_ADMIN_ROLE) {
            \Illuminate\Support\Facades\DB::table('model_has_roles')
                ->where('model_type', self::class)
                ->where('model_id', $this->id)
                ->delete();
            $this->unsetRelation('roles');
        }

        $this->assignRole($role);
    }

    /**
     * Why $newRole may not replace this admin's Super Admin role, or null when it may.
     * Nobody can take Super Admin from themselves, and the last Super Admin can't lose it.
     */
    public function superAdminRemovalError(string $newRole): ?string
    {
        if ($newRole === self::SUPER_ADMIN_ROLE || !$this->isSuperAdmin()) {
            return null;
        }

        $actor = auth('admin')->user() ?? auth('admin-api')->user();
        if ($actor instanceof self && $actor->is($this)) {
            return "You can't remove the Super Admin role from your own account.";
        }

        if (self::role(self::SUPER_ADMIN_ROLE, 'admin')->count() <= 1) {
            return 'At least one Super Admin must remain.';
        }

        return null;
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    // App tabs each admin can be given (column => label). Set explicitly by the dashboard,
    // deliberately not mass assignable.
    public const APP_TABS = [
        'table' => 'Table',
        'projects' => 'Projects',
        'tasks' => 'Tasks',
        'offline' => 'Offline Tasks',
        'marketting' => 'Marketing',
        'offline_center' => 'Offline Center',
        'locks' => 'Locks',
        'stats' => 'Stats',
        'info' => 'Info',
        'workspace' => 'Workspace',
        'sql' => 'SQL',
        'account' => 'Account',
        'explore' => 'Explore',
        'logout' => 'Logout',
    ];

    // Tabs that are on unless turned off (they were always visible before they had a switch)
    public const APP_TABS_ON_BY_DEFAULT = ['account', 'explore', 'logout'];

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
