<?php

namespace App\Services;

use App\Contracts\Repositories\MiscRepositoryInterface;

class MiscService
{
    protected $miscRepository;

    public function __construct(MiscRepositoryInterface $miscRepository)
    {
        $this->miscRepository = $miscRepository;
    }

    public function logTrack(string $payload)
    {
        return $this->miscRepository->logTrack($payload);
    }

    public function getAllBases()
    {
        return $this->miscRepository->allBases();
    }

    public function getRandomSurveys(int $take = 5)
    {
        return $this->miscRepository->randomSurveys($take);
    }

    public function getRepeatSurveyMinutes()
    {
        return $this->miscRepository->getRepeatSurveyMinutes();
    }

    public function getLastRepeatDate()
    {
        return $this->miscRepository->lastRepeatDate();
    }

    public function createRepeatTime(string $date)
    {
        return $this->miscRepository->createRepeat($date);
    }

    public function createProjectHour(array $data)
    {
        return $this->miscRepository->createProjectHour($data);
    }

    public function getRandomNotes(int $take = 300)
    {
        return $this->miscRepository->randomNotes($take);
    }

    public function getReadyResponseMessages()
    {
        return $this->miscRepository->allReadyResponseMessages();
    }

    public function getPaginatedElements(int $categoryId, array $filters)
    {
        return $this->miscRepository->paginateElements($categoryId, $filters);
    }
}
