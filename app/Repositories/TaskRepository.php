<?php

namespace App\Repositories;

use App\Contracts\Repositories\TaskRepositoryInterface;
use App\Models\Admin;
use App\Models\Deadline;
use App\Models\Task;
use Carbon\Carbon;
use Illuminate\Http\Request;

class TaskRepository implements TaskRepositoryInterface
{
    public function all()
    {
        return Task::get();
    }

    public function findById(int $id)
    {
        return Task::findOrFail($id);
    }

    public function create(array $data): Task
    {
        return Task::create($data);
    }

    public function update(int $id, array $data): Task
    {
        $task = Task::findOrFail($id);
        $task->update($data);
        return $task;
    }

    public function paginate(Request $request, array $options = [], int $perPage = 20)
    {
        return Task::filter($request, $options)->paginate($perPage);
    }

    public function paginateFinished(Request $request, int $perPage = 20)
    {
        return Task::filter($request, ['ignore_user_scope' => false])
            ->where('status', 1)
            ->paginate($perPage);
    }

    public function filterForOffline(Request $request): \Illuminate\Database\Eloquent\Collection
    {
        return Task::filter($request, ['ignore_user_scope' => false])
            ->orderBy('date', 'asc')
            ->where('status', 0)
            ->get();
    }

    public function paginateWithProject(Request $request, int $perPage = 20)
    {
        return Task::with('project')->filter($request)->paginate($perPage);
    }

    public function findByCredential(Request $request, int $credentialId, int $perPage = 7)
    {
        return Task::with('project')
            ->where('status', 0)
            ->whereHas('project', fn($q) => $q->where('d_B_credential_id', $credentialId))
            ->filter($request)
            ->orderByDesc('date')
            ->paginate($perPage);
    }

    public function bulkToggleStatus(array $ids, int $adminId): \Illuminate\Database\Eloquent\Collection
    {
        $tasks = Task::whereIn('id', $ids)->get();

        foreach ($tasks as $task) {
            if ($task->isFixed) continue;

            $task->status     = $task->status == 1 ? 0 : 1;
            $task->admin_id   = $adminId;
            $task->updated_at = now();
            $task->save();
        }

        return $tasks;
    }

    public function bulkAssignEmployees(array $ids, array $employeeIds, int $adminId): int
    {
        return Task::whereIn('id', $ids)->update([
            'employees' => json_encode($employeeIds),
            'admin_id'  => $adminId,
        ]);
    }

    public function bulkAssignProject(array $ids, int $projectId): int
    {
        return Task::whereIn('id', $ids)->update(['project_id' => $projectId]);
    }

    public function bulkUpdateDate(array $ids, string $date, int $adminId): int
    {
        return Task::whereIn('id', $ids)->update([
            'date'       => $date,
            'admin_id'   => $adminId,
            'updated_at' => now(),
        ]);
    }

    public function updateTasksToToday(): int
    {
        return Task::where('status', 0)->where('date', '<', today())->update(['date' => today()]);
    }

    public function toggleStatus(int $id): Task
    {
        $task = Task::findOrFail($id);
        $task->update(['status' => !$task->status]);
        return $task;
    }

    public function togglePiority(int $id): array
    {
        $task     = Task::find($id);
        $priority = $task->piority;

        if (!$priority) {
            Deadline::updateOrCreate(
                [
                    'title'             => $task->title . ' in ' . $task->project->title,
                    'deadlineable_id'   => $task->id,
                    'deadlineable_type' => Task::class,
                ],
                [
                    'date'     => Carbon::now()->addDay()->toDateString(),
                    'isActive' => 1,
                ]
            );
            $task->update(['piority' => !$priority]);

            return ['success' => true, 'task' => $task];
        }

        // Check if linked deadline is still pending
        $deadline = Deadline::where('deadlineable_type', Task::class)
            ->where('deadlineable_id', $task->id)
            ->first();

        if ($deadline && $deadline->status == 0) {
            return ['success' => false, 'message' => 'Delete it from deadlines first'];
        }

        $task->update(['piority' => !$priority]);

        return ['success' => true, 'task' => $task];
    }

    public function updateTitleAndComments(int $id, array $payload): Task
    {
        $task = Task::findOrFail($id);
        $task->update($payload);
        return $task;
    }

    /**
     * Returns active (status=0) employee list with their open-task counts.
     */
    public function employeesWithTaskCounts(): \Illuminate\Database\Eloquent\Collection
    {
        $employeesContainsSql = jsonArrayContainsIntSql('tasks.employees', 'admins.id');

        return Admin::where('isActive', 1)
            ->whereNotIn('type', ['client', 'prospective'])
            ->select('admins.*')
            ->selectRaw("(
                SELECT COUNT(*)
                FROM tasks
                WHERE tasks.status = 0
                AND $employeesContainsSql
            ) as active_tasks_count")
            ->orderBy('name')
            ->get();
    }
}
