<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TaskResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
public function toArray($request)
{
    return [
        'id'         => $this->id,
        'title'      => $this->title,
        'status'     => $this->status,
        'piority'    => $this->piority,
        'is_fixed'    => (bool) $this->is_fixed,   // cast to bool for JS
        'date'       => $this->date,
        'created_at' => $this->created_at?->format('Y-m-d'),
        'employee'   => taskEmployees($this, "mobile"),
        'employees'  => $this->employees ?? [],   // needed for bulk assign display
        'project'    => $this->project->title,
        'project_id' => $this->project_id,        // needed for project filter
        'is_yousab' => $this->project->is_yousab?true:false,        // needed for project filter
        'is_personal' => $this->project->is_personal,        // needed for project filter
        'isDeleted'  => (bool) !$this->is_active,  // if you use soft-delete via isActive
        'editlink'   => "https://reactdashboard.yousab-tech.com/tasks/" . $this->id . "/edit",
        'comments' => $this->comments,
        'images'=> $this->images,
    ];
}
}
