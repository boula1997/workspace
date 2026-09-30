<?php

namespace App\Contracts\Repositories;

interface MiscRepositoryInterface
{
    public function logTrack(string $payload): void;
    public function allBases(): \Illuminate\Database\Eloquent\Collection;
    public function randomSurveys(int $take = 5): \Illuminate\Support\Collection;
    public function getRepeatSurveyMinutes(): ?int;
    public function lastRepeatDate(): ?string;
    public function createRepeat(string $date): \App\Models\Repeat;
    public function createProjectHour(array $data): \App\Models\Projecthour;
    public function randomNotes(int $take = 300): \Illuminate\Database\Eloquent\Collection;
    public function allReadyResponseMessages(): \Illuminate\Database\Eloquent\Collection;
    public function paginateElements(int $categoryId, array $filters): \Illuminate\Contracts\Pagination\LengthAwarePaginator;
}
