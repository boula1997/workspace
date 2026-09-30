<?php

namespace App\Services;

use App\Contracts\Repositories\TaskRepositoryInterface;
use Illuminate\Http\Request;

class TaskService
{
    protected $taskRepository;

    public function __construct(TaskRepositoryInterface $taskRepository)
    {
        $this->taskRepository = $taskRepository;
    }

    public function getAllTasks()
    {
        return $this->taskRepository->all();
    }

    public function getTaskById(int $id)
    {
        return $this->taskRepository->findById($id);
    }

    public function createTask(array $data)
    {
        return $this->taskRepository->create($data);
    }

    public function updateTask(int $id, array $data)
    {
        return $this->taskRepository->update($id, $data);
    }

    public function paginateTasks(Request $request, array $options = [], int $perPage = 20)
    {
        return $this->taskRepository->paginate($request, $options, $perPage);
    }

    public function getEmployeesWithTaskCounts()
    {
        return $this->taskRepository->employeesWithTaskCounts();
    }

    public function getOfflineTasks(Request $request)
    {
        return $this->taskRepository->filterForOffline($request);
    }

    public function getTasksByCredential(Request $request, int $credentialId, int $perPage = 7)
    {
        return $this->taskRepository->findByCredential($request, $credentialId, $perPage);
    }

    public function bulkDeleteTasks(array $ids, int $adminId)
    {
        return $this->taskRepository->bulkToggleStatus($ids, $adminId);
    }

    public function bulkAssignTasks(array $ids, array $employeeIds, int $adminId)
    {
        return $this->taskRepository->bulkAssignEmployees($ids, $employeeIds, $adminId);
    }

    public function bulkAssignProject(array $ids, int $projectId)
    {
        return $this->taskRepository->bulkAssignProject($ids, $projectId);
    }

    public function bulkUpdateTaskDate(array $ids, string $date, int $adminId)
    {
        return $this->taskRepository->bulkUpdateDate($ids, $date, $adminId);
    }

    public function updateTasksToToday()
    {
        return $this->taskRepository->updateTasksToToday();
    }

    public function toggleTaskStatus(int $id)
    {
        return $this->taskRepository->toggleStatus($id);
    }

    public function toggleTaskPriority(int $id)
    {
        return $this->taskRepository->togglePiority($id);
    }

    public function updateTaskTitleAndComments(int $id, array $payload)
    {
        return $this->taskRepository->updateTitleAndComments($id, $payload);
    }
}
