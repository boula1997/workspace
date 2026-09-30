<?php

namespace App\Contracts\Repositories;

interface DashboardRepositoryInterface
{
    public function monthlyFinancials(int $year): array;
    public function allProjectsWithRest(): \Illuminate\Support\Collection;
    public function boardProjects(): \Illuminate\Database\Eloquent\Collection;
    public function allAdmins(): \Illuminate\Database\Eloquent\Collection;
    public function projectTrackCounts(\Carbon\Carbon $date, array $colors): \Illuminate\Database\Eloquent\Collection;
    public function feeStats(\Carbon\Carbon $startOfMonth, \Carbon\Carbon $endOfMonth): array;
    public function allTimeFeeStats(): array;
    public function activeTasksForEmployee(\App\Models\Admin $admin): \Illuminate\Support\Collection;
    public function issuesByOffline(): \Illuminate\Database\Eloquent\Collection;
}
