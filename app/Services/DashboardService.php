<?php

namespace App\Services;

use App\Contracts\Repositories\DashboardRepositoryInterface;
use Carbon\Carbon;
use App\Models\Admin;

class DashboardService
{
    protected $dashboardRepository;

    public function __construct(DashboardRepositoryInterface $dashboardRepository)
    {
        $this->dashboardRepository = $dashboardRepository;
    }

    public function getMonthlyFinancials(int $year)
    {
        return $this->dashboardRepository->monthlyFinancials($year);
    }

    public function getAllProjectsWithRest()
    {
        return $this->dashboardRepository->allProjectsWithRest();
    }

    public function getBoardProjects()
    {
        return $this->dashboardRepository->boardProjects();
    }

    public function getAllAdmins()
    {
        return $this->dashboardRepository->allAdmins();
    }

    public function getProjectTrackCounts(Carbon $date, array $colors)
    {
        return $this->dashboardRepository->projectTrackCounts($date, $colors);
    }

    public function getFeeStats(Carbon $startOfMonth, Carbon $endOfMonth)
    {
        return $this->dashboardRepository->feeStats($startOfMonth, $endOfMonth);
    }

    public function getAllTimeFeeStats()
    {
        return $this->dashboardRepository->allTimeFeeStats();
    }

    public function getActiveTasksForEmployee(Admin $admin)
    {
        return $this->dashboardRepository->activeTasksForEmployee($admin);
    }

    public function getOfflineIssues()
    {
        return $this->dashboardRepository->issuesByOffline();
    }

    public function getAllIssues()
    {
        return $this->dashboardRepository->allIssues();
    }
}
