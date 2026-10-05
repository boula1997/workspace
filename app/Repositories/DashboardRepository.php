<?php

namespace App\Repositories;

use App\Contracts\Repositories\DashboardRepositoryInterface;
use App\Models\Admin;
use App\Models\Clienttrack;
use App\Models\Fee;
use App\Models\Issue;
use App\Models\Project;
use App\Models\Task;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class DashboardRepository implements DashboardRepositoryInterface
{
    public function monthlyFinancials(int $year): array
    {
        $income   = [];
        $outcome  = [];
        $projects = [];

        for ($month = 1; $month <= 12; $month++) {
            $start = Carbon::createFromDate($year, $month, 1)->startOfMonth();
            $end   = Carbon::createFromDate($year, $month, 1)->endOfMonth();

            $income[]   = Fee::where('amount', '>', 0)->whereBetween('created_at', [$start, $end])->sum('amount');
            $outcome[]  = Fee::where('amount', '<', 0)->whereBetween('created_at', [$start, $end])->sum('amount') * -1;
            $projects[] = Project::whereBetween('created_at', [$start, $end])->where('cost', '>', 0)->count();
        }

        return [
            'income'   => $income,
            'outcome'  => $outcome,
            'projects' => $projects,
        ];
    }

    public function allProjectsWithRest(): \Illuminate\Support\Collection
    {
        return Project::latest()->get();
    }

    public function boardProjects(): \Illuminate\Database\Eloquent\Collection
    {
        return Project::orderBy('deadline', 'asc')->where('appearance', 1)->get();
    }

    public function allAdmins(): \Illuminate\Database\Eloquent\Collection
    {
        return Admin::all();
    }

    public function projectTrackCounts(Carbon $date, array $colors): \Illuminate\Database\Eloquent\Collection
    {
        return Clienttrack::join('projects', 'clienttracks.project_id', '=', 'projects.id')
            ->where('clienttracks.created_at', '>=', $date)
            ->select('projects.id as project_id', 'projects.title', DB::raw('COUNT(clienttracks.id) as total_tracks'))
            ->groupBy('projects.id', 'projects.title')
            ->having('total_tracks', '>', 0)
            ->get()
            ->map(function ($project, $index) use ($colors) {
                $project->color = $colors[$index % count($colors)];
                return $project;
            });
    }

    public function feeStats(Carbon $startOfMonth, Carbon $endOfMonth): array
    {
        return [
            'avg'     => Fee::whereBetween('created_at', [$startOfMonth, $endOfMonth])->sum('amount'),
            'income'  => Fee::where('amount', '>', 0)->whereBetween('created_at', [$startOfMonth, $endOfMonth])->sum('amount'),
            'outcome' => Fee::where('amount', '<', 0)->whereBetween('created_at', [$startOfMonth, $endOfMonth])->sum('amount'),
        ];
    }

    public function allTimeFeeStats(): array
    {
        return [
            'avg'     => Fee::sum('amount'),
            'income'  => Fee::where('amount', '>', 0)->sum('amount'),
            'outcome' => Fee::where('amount', '<', 0)->sum('amount'),
        ];
    }

    public function activeTasksForEmployee(Admin $admin): \Illuminate\Support\Collection
    {
        return Task::where('isActive', 1)
            ->where('status', 0)
            ->orderBy('date', 'asc')
            ->get()
            ->filter(function ($task) use ($admin) {
                $employeeIds = is_array($task->employees)
                    ? $task->employees
                    : (json_decode($task->employees, true) ?? []);

                return in_array($admin->id, $employeeIds);
            });
    }

    public function issuesByOffline(): \Illuminate\Database\Eloquent\Collection
    {
        return Issue::where('isOffline', 1)->latest()->get();
    }

    public function allIssues(): \Illuminate\Database\Eloquent\Collection
    {
        return Issue::latest()->get();
    }
}
