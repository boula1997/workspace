<?php

namespace App\Contracts\Repositories;

use Illuminate\Http\Request;

interface DeadlineRepositoryInterface
{
    public function allPending(): \Illuminate\Database\Eloquent\Collection;
    public function allOrdered(): \Illuminate\Database\Eloquent\Collection;
    public function find(int $id): ?\App\Models\Deadline;
    public function create(array $data): \App\Models\Deadline;
    public function update(int $id, array $data): \App\Models\Deadline;
    public function bulkUpdateDate(array $ids, string $date): int;
    public function updateProjectDeadline(int $projectId, string $date): \App\Models\Project;
    public function pendingProjectsSortedByDeadline(): \Illuminate\Database\Eloquent\Collection;
}
