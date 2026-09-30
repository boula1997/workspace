<?php

namespace App\Repositories;

use App\Contracts\Repositories\IssueRepositoryInterface;
use App\Models\Issue;
use App\Models\Project;

class IssueRepository implements IssueRepositoryInterface
{
    public function findById(int $id): ?Issue
    {
        return Issue::find($id);
    }

    public function getHollyMass(): ?Issue
    {
        return Issue::where('id', 66)->first();
    }

    public function getFacebookAds(): ?Issue
    {
        return Issue::where('id', 118)->first();
    }

    public function updateAiPrompt(string $type, int $id, string $prompt): object
    {
        if ($type === 'project') {
            $model = Project::findOrFail($id);
        } else {
            $model = Issue::findOrFail($id);
        }

        $model->update(['ai_prompt' => $prompt]);
        return $model;
    }

    public function getAiPrompt(string $type, int $id): object
    {
        if ($type === 'project') {
            return Project::findOrFail($id);
        } else {
            return Issue::findOrFail($id);
        }
    }
}
