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
        "counter"=>$this->counter,
        "created_at"=>$this->created_at,
        "employees"=>$this->employees,
        "employee_id"=>$this->employee_id,
        "id"=>$this->id,
        "isOverthinking"=>$this->isOverthinking,
        "keywords"=>$this->keywords,
        "level"=>$this->level,
        "piority"=>$this->piority,
        "project_id"=>$this->project_id,
        "status"=>$this->status,
        "title"=>$this->title,
        "active_tasks_count"=>5,
        "pending_tasks_count"=>5,
        "updated_at"=>$this->updated_at,
        ];


    }
}
