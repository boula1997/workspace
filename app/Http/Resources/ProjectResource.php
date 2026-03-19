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
            'dailyWorks' => count($this->dailyWorks),
            'projectBudgetDays' => projectBudgetDays($this),
            'projectFutureExpense' => $this->futureExpense,
            'renewalDate' => $this->renewalDate,
            'payed' => $this->payed,
            'deadline' => $this->deadline,
            'isyousap' => 1,
            'isPersonal' => $this->isPersonal,
            'days_to_deadline' => $this->deadline
                ? now()->diffInDays(\Carbon\Carbon::parse($this->deadline), false)+1 // false => allow negative
                : null,
            'rest' => rest($this),
            'whatsapp' => isset($this->admin)?$this->admin->whatsapp:null,
            'phone' => isset($this->admin)?$this->admin->phone:null,
            'messanger_id' => isset($this->admin)?$this->admin->messanger_id:null,
            'tasksCount' => $this->tasks()
            ->where('status', 0)
            ->count('title'),
            'tasks' => $this->tasks()
            ->where('status', 0)
            ->pluck('title'),
            'lastPayed' => optional($this->feeses->where('amount', '>', 0)->last())->created_at?->format('d-m-Y'),
            "color" => sprintf(
                "#%06s",
                substr(md5($this->id), 0, 6) // hash project id -> stable hex
            ),

        ];
    }
}
