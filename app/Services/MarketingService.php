<?php

namespace App\Services;

use App\Contracts\Repositories\MarketingRepositoryInterface;

class MarketingService
{
    protected $marketingRepository;

    public function __construct(MarketingRepositoryInterface $marketingRepository)
    {
        $this->marketingRepository = $marketingRepository;
    }

    public function createPost(string $text)
    {
        return $this->marketingRepository->createPost($text);
    }

    public function getPaginatedPosts(?string $search, int $perPage = 2)
    {
        return $this->marketingRepository->paginatePosts($search, $perPage);
    }

    public function deletePost(int $id)
    {
        return $this->marketingRepository->deletePost($id);
    }

    public function getCompetitors()
    {
        return $this->marketingRepository->competitors();
    }

    public function getJobs()
    {
        return $this->marketingRepository->jobs();
    }

    public function getMarketingTools()
    {
        return $this->marketingRepository->marketingTools();
    }
}
