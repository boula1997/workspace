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
    "#6a2eca", "#1abc9c", "#e74c3c", "#3498db", "#f39c12",
    "#2ecc71", "#9b59b6", "#34495e", "#16a085", "#c0392b",
    "#2980b9", "#d35400", "#27ae60", "#8e44ad", "#2c3e50",
    "#f1c40f", "#7f8c8d", "#e67e22", "#d35400", "#95a5a6",
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
            "color" => crc32($this->id) % count($palette),

        ];
    }
}
