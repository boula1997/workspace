<?php

namespace App\Services;

use App\Contracts\Repositories\GigRepositoryInterface;

class GigService
{
    protected $gigRepository;

    public function __construct(GigRepositoryInterface $gigRepository)
    {
        $this->gigRepository = $gigRepository;
    }

    public function createPhoneGig(array $data)
    {
        return $this->gigRepository->createPhoneGig($data);
    }

    public function getPaginatedPhoneGigs(int $perPage = 15, ?int $adminId = null)
    {
        return $this->gigRepository->paginatePhoneGigs($perPage, $adminId);
    }

    public function deletePhoneGig(int $id)
    {
        return $this->gigRepository->deletePhoneGig($id);
    }

    public function createPostGig(array $data)
    {
        return $this->gigRepository->createPostGig($data);
    }

    public function getPaginatedPostGigs(int $perPage = 15, ?int $adminId = null)
    {
        return $this->gigRepository->paginatePostGigs($perPage, $adminId);
    }

    public function deletePostGig(int $id)
    {
        return $this->gigRepository->deletePostGig($id);
    }

    public function createCallHistory(int $phoneGigId, ?int $adminId = null)
    {
        return $this->gigRepository->createCallHistory($phoneGigId, $adminId);
    }

    public function createLinkHistory(int $postGigId, ?int $adminId = null)
    {
        return $this->gigRepository->createLinkHistory($postGigId, $adminId);
    }

    public function phoneGigHistoryStats(int $phoneGigId, ?int $adminId): array
    {
        return $this->gigRepository->phoneGigHistoryStats($phoneGigId, $adminId);
    }

    public function postGigHistoryStats(int $postGigId, ?int $adminId): array
    {
        return $this->gigRepository->postGigHistoryStats($postGigId, $adminId);
    }

    public function phoneGigExists(string $phone): bool
    {
        return $this->gigRepository->phoneGigExists($phone);
    }
}
