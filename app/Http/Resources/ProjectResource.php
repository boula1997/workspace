<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProjectResource extends JsonResource
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
            'title' => $this->title,
            'status' => $this->status,
            'rest' => rest($this),
            'lastPayed' => optional($this->feeses->last())->created_at,

        ];
    }
}
