<?php

namespace App\Contracts\Repositories;

use Illuminate\Http\Request;

interface TaskRepositoryInterface
{
    public function all();
    public function findById(int $id);
    public function create(array $data);
    public function update(int $id, array $data);
    public function paginate(Request $request, array $options = [], int $perPage = 20);
    public function paginateFinished(Request $request, int $perPage = 20);
    public function filterForOffline(Request $request): \Illuminate\Database\Eloquent\Collection;
    public function paginateWithProject(Request $request, int $perPage = 20);
    public function findByCredential(Request $request, int $credentialId, int $perPage = 7);
    public function bulkToggleStatus(array $ids, int $adminId): \Illuminate\Database\Eloquent\Collection;
    public function bulkAssignEmployees(array $ids, array $employeeIds, int $adminId): int;
    public function bulkAssignProject(array $ids, int $projectId): int;
    public function bulkUpdateDate(array $ids, string $date, int $adminId): int;
    public function updateTasksToToday(): int;
    public function toggleStatus(int $id): \App\Models\Task;
    public function togglePiority(int $id): array;
    public function updateTitleAndComments(int $id, array $payload): \App\Models\Task;
}
