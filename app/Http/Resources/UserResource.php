<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'email' => $this->email,
            'username' => $this->username,
            'phone' => $this->phone ?? null,
            'instagramURL' => $this->instagramURL ?? null,
            'facebookURL' => $this->facebookURL ?? null,
            'linkedinURL' => $this->linkedinURL ?? null,
            'email_verified_at' => $this->email_verified_at,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            
            // Roles and Permissions - Always load
            'roles' => $this->getRolesArray(),
            'permissions' => $this->getDirectPermissionsArray(),
            'all_permissions' => $this->getAllPermissionsArray(),
        ];
    }

    /**
     * Get roles array
     *
     * @return array
     */
    private function getRolesArray()
    {
        // Check if already loaded
        if ($this->relationLoaded('roles')) {
            return $this->roles->pluck('name')->toArray();
        }
        
        // Load on demand
        return $this->roles()->pluck('name')->toArray();
    }

    /**
     * Get direct permissions array
     *
     * @return array
     */
    private function getDirectPermissionsArray()
    {
        // Check if already loaded
        if ($this->relationLoaded('permissions')) {
            return $this->permissions->pluck('name')->toArray();
        }
        
        // Load on demand
        return $this->permissions()->pluck('name')->toArray();
    }

    /**
     * Get all permissions for this user (direct + role-based).
     *
     * @return array
     */
    private function getAllPermissionsArray()
    {
        // Get direct permissions
        $directPermissions = $this->getDirectPermissionsArray();
        
        // Get permissions through roles
        $rolePermissions = [];
        $roles = $this->relationLoaded('roles') ? $this->roles : $this->roles;
        
        foreach ($roles as $role) {
            // Load permissions if not already loaded
            if ($role->relationLoaded('permissions')) {
                $perms = $role->permissions->pluck('name')->toArray();
            } else {
                $perms = $role->permissions()->pluck('name')->toArray();
            }
            
            $rolePermissions = array_merge($rolePermissions, $perms);
        }
        
        // Merge and remove duplicates
        $allPermissions = array_unique(array_merge($directPermissions, $rolePermissions));
        
        return array_values($allPermissions);
    }
}