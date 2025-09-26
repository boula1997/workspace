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
        "created_at"=>$this->created_at,
        "email"=>$this->email,
        "email_verified_at"=>$this->email_verified_at,
        "id"=>$this->id,
        "isActive"=>$this->isActive,
        "messanger_id"=>$this->messanger_id,
        "name"=>$this->name,
        "password"=>$this->password,
        "phone"=>$this->phone,
        "remember_token"=>$this->remember_token,
        "type"=>$this->type,
        "updated_at"=>$this->updated_at,
        "whatsapp"=>$this->whatsapp,
        "active_tasks_count"=>5,
        "pending_tasks_count"=>5,
        ];


    }
}
