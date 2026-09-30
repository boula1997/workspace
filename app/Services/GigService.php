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

    public function getPaginatedPhoneGigs(int $perPage = 15)
    {
        return $this->gigRepository->paginatePhoneGigs($perPage);
    }

    public function deletePhoneGig(int $id)
    {
        return $this->gigRepository->deletePhoneGig($id);
    }

    public function createPostGig(array $data)
    {
        return $this->gigRepository->createPostGig($data);
    }

    public function getPaginatedPostGigs(int $perPage = 15)
    {
        return $this->gigRepository->paginatePostGigs($perPage);
    }

    public function deletePostGig(int $id)
    {
        return $this->gigRepository->deletePostGig($id);
    }

    public function createCallHistory(int $phoneGigId)
    {
        return $this->gigRepository->createCallHistory($phoneGigId);
    }

    public function createLinkHistory(int $postGigId)
    {
        return $this->gigRepository->createLinkHistory($postGigId);
    }

    public function phoneGigExists(string $phone): bool
    {
        return $this->gigRepository->phoneGigExists($phone);
    }
}
