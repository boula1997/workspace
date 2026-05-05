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
            
            // Roles and Permissions
            'roles' => $this->whenLoaded('roles', function () {
                return $this->roles->pluck('name')->toArray();
            }),
            
            'permissions' => $this->whenLoaded('permissions', function () {
                return $this->permissions->pluck('name')->toArray();
            }),
            
            'all_permissions' => $this->whenLoaded('roles', function () {
                return $this->getAllPermissions();
            }),
        ];
    }

    /**
     * Get all permissions for this user (direct + role-based).
     *
     * @return array
     */
    private function getAllPermissions()
    {
        // Get direct permissions
        $directPermissions = $this->permissions->pluck('name')->toArray();
        
        // Get permissions through roles
        $rolePermissions = [];
        foreach ($this->roles as $role) {
            $rolePermissions = array_merge(
                $rolePermissions,
                $role->permissions->pluck('name')->toArray()
            );
        }
        
        // Merge and remove duplicates
        $allPermissions = array_unique(array_merge($directPermissions, $rolePermissions));
        
        return array_values($allPermissions);
    }
}
