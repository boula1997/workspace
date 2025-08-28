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
        $palette = [
    "#6a2eca", // purple
    "#1abc9c", // teal
    "#e74c3c", // red
    "#3498db", // blue
    "#f39c12", // orange
    "#2ecc71", // green
    "#9b59b6", // violet
    "#34495e", // dark gray-blue
];

        return [
            "id" => $this->id,
            'title' => $this->title,
            'deal' => $this->deal,
            'status' => $this->status,
            'cost' => $this->cost,
            'deadline' => $this->deadline,
            'days_to_deadline' => $this->deadline
                ? now()->diffInDays(\Carbon\Carbon::parse($this->deadline), false)+1 // false => allow negative
                : null,
            'rest' => rest($this),
            'tasksCount' => $this->tasks()
            ->where('status', 0)
            ->distinct('title')
            ->count('title'),
            'lastPayed' => optional($this->feeses->where('amount', '>', 0)->last())->created_at?->format('d-m-Y'),
"color" => $palette[$this->id % count($palette)],

        ];
    }
}
