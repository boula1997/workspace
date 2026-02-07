<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class DealResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray($request)
    {
        return [
            "id" => $this->id,
            'title'=>$this->title,
            'isSettled'=>$this->isSettled,
            'cost'=>$this->cost,
            'description'=>$this->description,
            'project'=>$this->project->title,
            "editlink"=>"https://reactdashboard.yousab-tech.com/tasks/".$this->id."/edit"
        ];
    }
}
    