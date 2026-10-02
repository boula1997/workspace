<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\IssueResource;
use App\Http\Resources\ProjectResource;
use App\Models\Project;
use App\Models\Issue;
use App\Services\DashboardService;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    protected $dashboardService;

    public function __construct(DashboardService $dashboardService)
    {
        $this->dashboardService = $dashboardService;
    }

    /**
     * GET /stats
     * Returns comprehensive financial and project statistics for a given date/year.
     */
    public function stats()
    {
        $date = request()->query('date')
            ? Carbon::parse(request()->query('date'))
            : Carbon::now();

        $startOfMonth = $date->copy()->startOfMonth();
        $endOfMonth   = $date->copy()->endOfMonth();
        $year         = $date->year;

        $monthlyData = $this->dashboardService->getMonthlyFinancials($year);

        $feeStats = $this->dashboardService->getFeeStats($startOfMonth, $endOfMonth);
        $allTimeFeeStats = $this->dashboardService->getAllTimeFeeStats();

        // Project collections
        $projects = $this->dashboardService->getAllProjectsWithRest();

        $selectedProjects = $projects->filter(function ($project) {
            return rest($project) > 0 || ($project->status == 2 && $project->cost != 0);
        })->sortByDesc(fn($project) => rest($project));

        $dueMoneyProjects = $projects->filter(function ($project) {
            return rest($project) > 0 && $project->status == 2;
        })->sortByDesc(fn($project) => rest($project));

        $totalRest       = $selectedProjects->sum(fn($project) => rest($project));
        $totalDueRest    = $dueMoneyProjects->sum(fn($project) => rest($project));
        $totalFutureRest = $totalRest - $totalDueRest;
        $totalCost       = $selectedProjects->sum('cost');

        $boardProjects = Project::get(); // Still using Eloquent directly here for simplicity if needed, but preferable to use service if possible, though I'm keeping some things minimal for speed.

        $contractProjects = $boardProjects->filter(fn($p) => $p->status == 2 && $p->cost == 0);
        $moneyProjects    = $boardProjects->filter(fn($p) => $p->status == 2 && $p->cost > 0);
        $progressProjects = $boardProjects->filter(fn($p) => $p->status == 1);
        $finishedProjects = $boardProjects->filter(fn($p) => $p->status == 0);

        $moneyProjectIds = Project::where('status', 2)->where('cost', '>', 0)->pluck('id');

        $moneyProjectsList = $selectedProjects->filter(
            fn($project) => $moneyProjectIds->contains($project->id)
        );

        $colors = [
            '#FF6384', '#36A2EB', '#FFCE56', '#4BC0C0', '#9966FF',
            '#FF9F40', '#C9CBCF', '#8A2BE2', '#00FF7F', '#FF4500',
        ];

        $projectTrackCounts = $this->dashboardService->getProjectTrackCounts($date, $colors);

        $allProjects = Project::where('cost', '>', 0)->count();

        return successResponse([
            'projects'             => ProjectResource::collection($selectedProjects),
            'boardProjects'        => ProjectResource::collection(
                Project::latest()->get()->sortByDesc(fn($project) => rest($project))
            ),
            'conMoneyProjects'     => ProjectResource::collection(
                Project::get()
                    ->filter(fn($project) => $project->status == 2 || $project->deal == 0)
                    ->sortByDesc(fn($project) => $project->status)
            ),
            'renewalProjects'      => ProjectResource::collection(
                Project::whereNotNull('renewalDate')
                    ->orderBy('renewalDate', 'asc')
                    ->whereDate('renewalDate', '<=', Carbon::now()->addWeek())
                    ->get()
            ),
            'taskProjects'         => ProjectResource::collection(
                Project::withCount([
                    'tasks as pending_tasks_count' => function ($q) {
                        $q->where('status', 0)->select(DB::raw('COUNT(DISTINCT title)'));
                    }
                ])->latest()->get()
                  ->filter(fn($p) => rest($p) > 0)
                  ->sortByDesc('pending_tasks_count')
            ),
            'deadlineProjects'     => ProjectResource::collection(
                Project::whereNotNull('deadline')
                    ->whereDate('deadline', '>=', now())
                    ->whereHas('tasks', fn($q) => $q->where('status', 0))
                    ->orderBy('deadline')
                    ->get()
                    ->filter(fn($p) => rest($p) > 0)
            ),
            'avgFees'              => $feeStats['avg'],
            'incomeFees'           => $feeStats['income'],
            'outcomeFees'          => $feeStats['outcome'],
            'allavgFees'           => $allTimeFeeStats['avg'],
            'alloutcomeFees'       => $allTimeFeeStats['outcome'] * -1,
            'allincomeFees'        => $allTimeFeeStats['income'],
            'yearTotalIncome'      => array_sum($monthlyData['income']),
            'yearTotalOutcome'     => array_sum($monthlyData['outcome']),
            'monthlyIncomeArray'   => $monthlyData['income'],
            'monthlyOutcomeArray'  => $monthlyData['outcome'],
            'monthlyProjectsArray' => $monthlyData['projects'],
            'moneyProjectIds'      => $moneyProjectIds,
            'allProjects'          => $allProjects,
            'pieCostProjects'      => ProjectResource::collection(
                Project::where('cost', '>', 0)->orderBy('cost', 'desc')->take(15)->get()
            ),
            'last_time'            => setting()->last_time . ' ' . getTimeAgo(setting()->last_time),
            'allowedIn'            => date('Y-m-d', strtotime(setting()->last_time . ' + 3 days')),
            'deadlineAction'       => activeDeadline()['action'],
            'deadlineDate'         => activeDeadline()['deadline'],
            'totalRest'            => $totalRest,
            'totalGained'          => $totalCost - $totalRest,
            'totalDueRest'         => $totalDueRest,
            'totalFutureRest'      => $totalFutureRest,
            'target'               => settings()->target,
            'contractProjects'     => count($contractProjects),
            'moneyProjectsListCount' => count($moneyProjectsList),
            'contracts'            => $contractProjects,
            'moneyProjects'        => count($moneyProjects),
            'progressProjects'     => count($progressProjects),
            'finishedProjects'     => count($finishedProjects),
            'isExpired'            => isExpired()[0],
            'clientsCount'         => \App\Models\Admin::where('type', 'client')->count(),
            'prospectivesCount'    => \App\Models\Admin::where('type', 'prospective')->count(),
            'projectTrackCounts'   => $projectTrackCounts,
        ]);
    }

    /**
     * GET /board/projects
     * Returns all active projects with their deadlines and admin list.
     */
    public function boardProjects()
    {
        return successResponse([
            'boardProjects' => ProjectResource::collection(
                $this->dashboardService->getBoardProjects()
            ),
            'admins' => $this->dashboardService->getAllAdmins(),
        ]);
    }

    /**
     * GET /data/info
     * Returns all projects and (for Boula) all issues for offline reference data.
     */
    public function info()
    {
        $infoProjects = $this->dashboardService->getAllProjectsWithRest();
        $issues       = boula() ? $this->dashboardService->getOfflineIssues() : collect();

        return successResponse([
            'infoProjects' => ProjectResource::collection($infoProjects),
            'refrences'    => IssueResource::collection($issues),
        ]);
    }

    /**
     * GET /lock
     * Returns the list of pending tasks assigned to Boula, used to enforce the lock screen.
     */
    public function lock()
    {
        try {
            if (!boula()) {
                return successResponse([
                    'lock'      => [],
                    'isExpired' => isExpired()[0],
                ]);
            }

            $boula = \App\Models\Admin::where('name', 'Boula D')->first();

            if (!$boula) {
                return successResponse([
                    'lock'      => [],
                    'isExpired' => isExpired()[0],
                ]);
            }

            $expiredDeadlines = $this->dashboardService->getActiveTasksForEmployee($boula);

            $locks = $expiredDeadlines->map(
                fn($task) => $task->title . ' in ' . $task->project->title
            )->values()->all();

            return successResponse([
                'lock'      => $locks,
                'isExpired' => isExpired()[0],
            ]);
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()]);
        }
    }

    /**
     * GET /offline/info
     * Returns issues marked for offline use.
     */
    public function offlineInfo()
    {
        $issues = $this->dashboardService->getOfflineIssues();

        return successResponse($issues);
    }

    /**
     * POST /async/offline/info
     * Bulk-updates project or issue fields from the offline client.
     */
    public function asyncOfflineInfo(Request $request)
    {
        $validated = $request->validate([
            'updates'                          => 'required|array',
            'updates.*.project_id'             => 'nullable|integer|exists:projects,id',
            'updates.*.refrence_id'            => 'nullable|integer|exists:issues,id',
            'updates.*.name'                   => 'nullable|string',
            'updates.*.title'                  => 'nullable|string',
            'updates.*.ai_prompt'              => 'nullable|string',
            'updates.*.cost'                   => 'nullable',
            'updates.*.payed'                  => 'nullable',
            'updates.*.deal'                   => 'nullable',
            'updates.*.fixed'                  => 'nullable',
            'updates.*.isHosted'               => 'nullable',
            'updates.*.isOverthinking'         => 'nullable',
            'updates.*.deadline'               => 'nullable|date',
            'updates.*.renewalDate'            => 'nullable|date',
            'updates.*.githubDevModeLinkBack'  => 'nullable|string',
            'updates.*.githubDevModeLinkFront' => 'nullable|string',
        ]);

        // Mapping: DB column => payload key
        $projectColumns = [
            'ai_prompt'      => 'title',
            'isOverthinking' => 'isOverthinking',
        ];

        $issueColumns = [
            'ai_prompt'      => 'title',
            'isOverthinking' => 'isOverthinking',
        ];

        DB::transaction(function () use ($validated, $projectColumns, $issueColumns) {
            foreach ($validated['updates'] as $update) {
                if (!empty($update['project_id'])) {
                    $attrs = [];
                    foreach ($projectColumns as $dbCol => $payloadKey) {
                        if (array_key_exists($payloadKey, $update)) {
                            $attrs[$dbCol] = $update[$payloadKey];
                        }
                    }
                    if (!empty($attrs)) {
                        Project::whereKey($update['project_id'])->update($attrs);
                    }
                } elseif (!empty($update['refrence_id'])) {
                    $attrs = [];
                    foreach ($issueColumns as $dbCol => $payloadKey) {
                        if (array_key_exists($payloadKey, $update)) {
                            $attrs[$dbCol] = $update[$payloadKey];
                        }
                    }
                    if (!empty($attrs)) {
                        Issue::whereKey($update['refrence_id'])->update($attrs);
                    }
                }
            }
        });

        return successResponse(Issue::latest()->get());
    }
}
