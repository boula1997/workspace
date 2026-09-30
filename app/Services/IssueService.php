<?php

namespace App\Services;

use App\Contracts\Repositories\IssueRepositoryInterface;

class IssueService
{
    protected $issueRepository;

    public function __construct(IssueRepositoryInterface $issueRepository)
    {
        $this->issueRepository = $issueRepository;
    }

    public function getIssueById(int $id)
    {
        return $this->issueRepository->findById($id);
    }

    public function getHollyMassIssue()
    {
        return $this->issueRepository->getHollyMass();
    }

    public function getFacebookAdsIssue()
    {
        return $this->issueRepository->getFacebookAds();
    }

    public function updateAiPrompt(string $type, int $id, string $prompt)
    {
        return $this->issueRepository->updateAiPrompt($type, $id, $prompt);
    }

    public function getAiPrompt(string $type, int $id)
    {
        return $this->issueRepository->getAiPrompt($type, $id);
    }
}
