<?php

namespace App\Contracts\Repositories;

interface IssueRepositoryInterface
{
    public function findById(int $id): ?\App\Models\Issue;
    public function getHollyMass(): ?\App\Models\Issue;
    public function getFacebookAds(): ?\App\Models\Issue;
    public function updateAiPrompt(string $type, int $id, string $prompt): object;
    public function getAiPrompt(string $type, int $id): object;
}
