<?php

namespace App\Services;

use App\Contracts\Repositories\DeadlineRepositoryInterface;

class DeadlineService
{
    protected $deadlineRepository;

    public function __construct(DeadlineRepositoryInterface $deadlineRepository)
    {
        $this->deadlineRepository = $deadlineRepository;
    }

    public function getPendingDeadlines()
    {
        return $this->deadlineRepository->allPending();
    }

    public function getAllOrdered()
    {
        return $this->deadlineRepository->allOrdered();
    }

    public function createDeadline(array $data)
    {
        return $this->deadlineRepository->create($data);
    }

    public function updateDeadline(int $id, array $data)
    {
        return $this->deadlineRepository->update($id, $data);
    }

    public function getDeadlineById(int $id)
    {
        return $this->deadlineRepository->find($id);
    }

    public function bulkUpdateDates(array $ids, string $date)
    {
        return $this->deadlineRepository->bulkUpdateDate($ids, $date);
    }

    public function updateProjectDeadline(int $projectId, string $date)
    {
        return $this->deadlineRepository->updateProjectDeadline($projectId, $date);
    }

    public function getPendingProjectsSortedByDeadline()
    {
        return $this->deadlineRepository->pendingProjectsSortedByDeadline();
    }
}
