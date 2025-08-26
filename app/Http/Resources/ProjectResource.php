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
            'deal' => $this->deal,
            'status' => $this->status,
            'cost' => $this->cost,
            'rest' => rest($this),
            'tasksCount' => $this->tasks()->count(), // ✅ safest
            'lastPayed' => optional($this->feeses->where('amount', '>', 0)->last())->created_at?->format('d-m-Y'),

        ];
    }
}
