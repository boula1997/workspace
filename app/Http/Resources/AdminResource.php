<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AdminResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray($request)
    {
        return [
            "created_at" => $this->created_at,
            "email" => $this->email,
            "email_verified_at" => $this->email_verified_at,
            "id" => $this->id,
            "isActive" => $this->isActive,
            "messanger_id" => $this->messanger_id,
            "name" => $this->name,
            "phone" => $this->phone,
            "remember_token" => $this->remember_token,
            "type" => $this->type,
            "updated_at" => $this->updated_at,
            "whatsapp" => $this->whatsapp,
            "active_tasks_count" => 5,
            "pending_tasks_count" => 5,
            
            // Roles and Permissions
            "roles" => $this->getRolesArray(),
            "direct_permissions" => $this->getDirectPermissionsArray(),
            "permissions" => $this->getAllPermissionsArray(),
            "all_permissions" => $this->getAllPermissionsArray(),
            "table" => $this->table?true:false,
            "projects" => $this->projects?true:false,
            "tasks" => $this->tasks?true:false,
            "marketting" => $this->marketting?true:false,
            "offline_center" => $this->offline_center?true:false,
            "locks" => $this->locks?true:false,
            "stats" => $this->stats?true:false,
            "info" => $this->info?true:false,
            "workspace" => $this->workspace?true:false,
            "sql" => $this->sql?true:false,
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
     * Get all permissions for this admin (direct + role-based).
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
