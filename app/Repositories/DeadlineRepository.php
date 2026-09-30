<?php

namespace App\Repositories;

use App\Contracts\Repositories\DeadlineRepositoryInterface;
use App\Models\Deadline;
use App\Models\Project;
use Carbon\Carbon;

class DeadlineRepository implements DeadlineRepositoryInterface
{
    public function allPending(): \Illuminate\Database\Eloquent\Collection
    {
        return Deadline::where('status', 0)->orderBy('date', 'asc')->get();
    }

    public function allOrdered(): \Illuminate\Database\Eloquent\Collection
    {
        return Deadline::orderBy('date', 'asc')->get();
    }

    public function find(int $id): ?Deadline
    {
        return Deadline::find($id);
    }

    public function create(array $data): Deadline
    {
        return Deadline::create($data);
    }

    public function update(int $id, array $data): Deadline
    {
        $deadline = Deadline::findOrFail($id);
        $deadline->update($data);
        return $deadline->fresh();
    }

    public function bulkUpdateDate(array $ids, string $date): int
    {
        return Deadline::query()
            ->whereIn('id', $ids)
            ->where('status', 0)
            ->update(['date' => $date, 'updated_at' => now()]);
    }

    public function updateProjectDeadline(int $projectId, string $date): Project
    {
        $project      = Project::findOrFail($projectId);
        $deadlineTime = Carbon::parse($date, 'UTC')->setTimezone('Africa/Cairo');
        $project->update(['deadline' => $deadlineTime]);
        return $project;
    }

    public function pendingProjectsSortedByDeadline(): \Illuminate\Database\Eloquent\Collection
    {
        return Project::orderBy('deadline', 'asc')
            ->get()
            ->filter(fn($project) => $project->status != 1);
    }
}
