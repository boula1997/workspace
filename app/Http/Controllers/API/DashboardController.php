<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\ProjectResource;
use App\Http\Resources\IssueResource;
use App\Models\Admin;
use App\Models\Clienttrack;
use App\Models\Fee;
use App\Models\Issue;
use App\Models\Project;
use App\Models\Task;
use Exception;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    /**
     * GET /stats
     * Returns comprehensive financial and project statistics for a given date/year.
     */
    public function stats()
    {
        $date         = request()->query('date')
            ? Carbon::parse(request()->query('date'))
            : Carbon::now();

        $startOfMonth = $date->copy()->startOfMonth();
        $endOfMonth   = $date->copy()->endOfMonth();
        $year         = $date->year;

        // Build monthly income/outcome/project arrays for the year
        $monthlyIncomeArray   = [];
        $monthlyOutcomeArray  = [];
        $monthlyProjectsArray = [];
        $yearTotalIncome      = 0;
        $yearTotalOutcome     = 0;

        for ($month = 1; $month <= 12; $month++) {
            $start = Carbon::createFromDate($year, $month, 1)->startOfMonth();
            $end   = Carbon::createFromDate($year, $month, 1)->endOfMonth();

            $monthlyIncome  = Fee::where('amount', '>', 0)->whereBetween('created_at', [$start, $end])->sum('amount');
            $monthlyOutcome = Fee::where('amount', '<', 0)->whereBetween('created_at', [$start, $end])->sum('amount');
            $monthlyProjects = Project::whereBetween('created_at', [$start, $end])->where('cost', '>', 0)->count();

            $monthlyIncomeArray[]   = $monthlyIncome;
            $monthlyOutcomeArray[]  = $monthlyOutcome * -1;
            $monthlyProjectsArray[] = $monthlyProjects;
            $yearTotalIncome       += $monthlyIncome;
            $yearTotalOutcome      += $monthlyOutcome * -1;
        }

        // Monthly stats for the selected month
        $avgFees     = Fee::whereBetween('created_at', [$startOfMonth, $endOfMonth])->sum('amount');
        $incomeFees  = Fee::where('amount', '>', 0)->whereBetween('created_at', [$startOfMonth, $endOfMonth])->sum('amount');
        $outcomeFees = Fee::where('amount', '<', 0)->whereBetween('created_at', [$startOfMonth, $endOfMonth])->sum('amount');

        // All-time stats
        $allavgFees     = Fee::sum('amount');
        $allincomeFees  = Fee::where('amount', '>', 0)->sum('amount');
        $alloutcomeFees = Fee::where('amount', '<', 0)->sum('amount');

        // Project collections
        $projects = Project::latest()->get();

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

        $boardProjects = Project::get();

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

        $projectTrackCounts = Clienttrack::join('projects', 'clienttracks.project_id', '=', 'projects.id')
            ->where('clienttracks.created_at', '>=', $date)
            ->select('projects.id as project_id', 'projects.title', DB::raw('COUNT(clienttracks.id) as total_tracks'))
            ->groupBy('projects.id', 'projects.title')
            ->having('total_tracks', '>', 0)
            ->get()
            ->map(function ($project, $index) use ($colors) {
                $project->color = $colors[$index % count($colors)];
                return $project;
            });

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
            'avgFees'              => $avgFees,
            'incomeFees'           => $incomeFees,
            'outcomeFees'          => $outcomeFees,
            'allavgFees'           => $allavgFees,
            'alloutcomeFees'       => $alloutcomeFees * -1,
            'allincomeFees'        => $allincomeFees,
            'yearTotalIncome'      => $yearTotalIncome,
            'yearTotalOutcome'     => $yearTotalOutcome,
            'monthlyIncomeArray'   => $monthlyIncomeArray,
            'monthlyOutcomeArray'  => $monthlyOutcomeArray,
            'monthlyProjectsArray' => $monthlyProjectsArray,
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
            'clientsCount'         => Admin::where('type', 'client')->count(),
            'prospectivesCount'    => Admin::where('type', 'prospective')->count(),
            'projectTrackCounts'   => $projectTrackCounts,
        ]);
    }

    /**
     * GET /board/projects
     * Returns all active projects with their deadlines and admin list.
     */
    public function boardProjects()
    {
        $admins = Admin::all();

        return successResponse([
            'boardProjects' => ProjectResource::collection(
                Project::orderBy('deadline', 'asc')->where('appearance', 1)->get()
            ),
            'admins' => $admins,
        ]);
    }

    /**
     * GET /data/info
     * Returns all projects and (for Boula) all issues for offline reference data.
     */
    public function info()
    {
        $infoProjects = Project::orderBy('title', 'asc')->get();
        $issues       = boula() ? Issue::orderBy('title', 'asc')->get() : collect();

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

            $boula = Admin::where('name', 'Boula D')->first();

            if (!$boula) {
                return successResponse([
                    'lock'      => [],
                    'isExpired' => isExpired()[0],
                ]);
            }

            $expiredDeadlines = Task::where('isActive', 1)
                ->where('status', 0)
                ->orderBy('date', 'asc')
                ->get()
                ->filter(function ($task) use ($boula) {
                    $employeeIds = is_array($task->employees)
                        ? $task->employees
                        : (json_decode($task->employees, true) ?? []);

                    return in_array($boula->id, $employeeIds);
                });

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
        $issues = Issue::where('isOffline', 1)->latest()->get();

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
            'title'                  => 'name',
            'cost'                   => 'cost',
            'deadline'               => 'deadline',
            'fixed'                  => 'fixed',
            'isHosted'               => 'isHosted',
            'isOverthinking'         => 'isOverthinking',
            'renewalDate'            => 'renewalDate',
            'githubDevModeLinkBack'  => 'githubDevModeLinkBack',
            'githubDevModeLinkFront' => 'githubDevModeLinkFront',
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
