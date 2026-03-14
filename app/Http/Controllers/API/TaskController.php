<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\TaskRequest;
use App\Http\Resources\ProjectResource;
use App\Http\Resources\NavigationResource;
use App\Http\Resources\IssueResource;
use App\Http\Resources\TaskResource;
use App\Http\Resources\DealResource;
use App\Models\KitTool;
use App\Models\Query;
use App\Models\Project;
use App\Models\Issue;
use App\Models\Overtime;
use App\Models\Fear;
use App\Models\Repeat;
use App\Models\Fee;
use App\Models\Note;
use App\Models\Admin;
use App\Models\Deadline;
use App\Models\Category;
use App\Models\Video;
use App\Models\Base;
use App\Models\Navigation;
use App\Models\Clienttrack;
use App\Models\Task;
use App\Models\DailyWork;
use App\Models\DBCredential;
use App\Models\Deal;
use Spatie\Permission\Models\Role;

use App\Models\Gallery;
use Exception;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;


class TaskController extends Controller
{
    private $task;
    public function __construct(Task $task)
    {
        updateStopClosingStatus();
        $this->task = $task;
    }

    public function index()
    {
        try {
            $data['tasks'] = TaskResource::collection($this->task->get());
            return successResponse($data);
        } catch (Exception $e) {

            return failedResponse($e->getMessage());
        }
    }

    public function show($id)
    {
        try {
            $data['task'] = new TaskResource($this->task->findorfail($id));
            return successResponse($data);
        } catch (Exception $e) {

            return failedResponse($e->getMessage());
        }
    }


    public function create(Request $request)
    {
        $employees = Admin::where("isActive", 1)
            ->where("type", "!=", "client")->where("type", "!=", "prospective")
            ->select('admins.*')
            ->selectRaw("
                (
                    SELECT COUNT(*)
                    FROM tasks
                    WHERE tasks.status = 0
                    AND JSON_CONTAINS(tasks.employees, JSON_QUOTE(CAST(admins.id AS CHAR)))
                ) as active_tasks_count
            ")
            ->orderBy('name', 'ASC')
            ->get();

        if (auth("api")->user()->email == "parcel@gmail.com")
        $employees = Admin::where("email", auth("api")->user()->email)->get();
        $clients = Admin::where("isActive", 1)->where("type", "client")->orderBy('name', 'ASC')->get();
        $prospectives = Admin::where("isActive", 1)->where("type", "prospective")->orderBy('name', 'ASC')->get();



        if (auth("api")->user()->email == "parcel@gmail.com")
            $projects = Project::orderBy("title", "asc")->where("title", "Parcel Express")
                ->get();
        else{
            $allProjects = Project::orderBy("title", "asc")
            ->get();

            $projects = $allProjects->filter(function ($project) {
                return rest($project) > 0;
            });

        }

        if (!isWithinWorkingHours()) {
            $tasksQuery = Task::where("status", 0)
                ->where("isOverthinking", 0)
                ->orderBy('project_id', 'asc')    // Then by project_id (ascending)
                ->latest('updated_at')            // Then by latest update
                // Limit to 300 tasks
            ;

        } else {
            $tasksQuery = Task::where("status", 0)
                ->orderBy('project_id', 'asc')    // Then by project_id (ascending)
                ->latest('updated_at')            // Then by latest update
                // Limit to 300 tasks
            ;
        }

        // Apply search filter if present
if ($request->has('search') && $request->search != '') {
    $searchTerms = explode(',', $request->search);

    $tasksQuery->where(function ($q) use ($searchTerms) {
        foreach ($searchTerms as $term) {
            $term = trim($term);
            if (!$term) continue;

            // Check for priority special cases first
            if (strtolower($term) === "priority") {
                $q->orWhere('piority', 1);
                continue;
            }
            if (strtolower($term) === "!priority") {
                $q->orWhere('piority', 0);
                continue;
            }

            // General search by title, project, or employee
            $q->orWhere('title', 'like', "%$term%")
              ->orWhereHas('project', function ($qp) use ($term) {
                  $qp->where('title', 'like', "%$term%");
              })
              ->orWhere(function ($qe) use ($term) {
                  $qe->whereRaw("EXISTS (
                      SELECT 1
                      FROM admins
                      WHERE JSON_CONTAINS(tasks.employees, CAST(admins.id AS JSON))
                      AND admins.name LIKE ?
                  )", ["%$term%"]);
              });
        }
    });
}


        if (auth("api")->user()->email == "parcel@gmail.com")
            $tasksQuery = Task::where("status", 0)->where("project_id", parcelProject()->id);

        // Paginate tasks 
        $tasks = $tasksQuery->paginate(10);


        if (boula())
            $data = [
                "projects" => ProjectResource::collection($projects),
                "employees" => $employees,
                "clients" => $clients,
                "prospectives" => $prospectives,
                "tasks" => TaskResource::collection($tasks),
                "tasks_meta" => [
                    "current_page" => $tasks->currentPage(),
                    "last_page" => $tasks->lastPage(),
                    "per_page" => $tasks->perPage(),
                    "total" => $tasks->total(),
                ],
                "last_time" => setting()->last_time . ' ' . getTimeAgo(setting()->last_time),
                "isExpired" => isExpired()[0],
                "headings" => [
                    "allowedIn" => date('Y-m-d', strtotime(setting()->last_time . ' + 3 days')),
                    "deadlineAction" => activeDeadline()["action"],
                    "deadlineDate" => activeDeadline()["deadline"],
                ]

            ];

        else
            $data = [
                "projects" => ProjectResource::collection($projects),
                "employees" => $employees,
                "clients" => $clients,
                "prospectives" => $prospectives,
                "tasks" => TaskResource::collection($tasks),
                "tasks_meta" => [
                    "current_page" => $tasks->currentPage(),
                    "last_page" => $tasks->lastPage(),
                    "per_page" => $tasks->perPage(),
                    "total" => $tasks->total(),
                ],
                "last_time" => setting()->last_time . ' ' . getTimeAgo(setting()->last_time),

            ];

        return successResponse($data);
    }


/**
 * Filter tasks with advanced filters
 * GET /api/apptask/tasks  (same endpoint, handles both filtered and unfiltered)
 * Params: page, search, status, start_date, end_date, employees, projects
 */
public function tasks(Request $request)
{
   $query = Task::query()
    ->orderByRaw('ISNULL(date), date ASC')
    ->orderBy('id', 'ASC');

    // --- Scope to logged-in employee unless isBoula() ---
    $user = auth()->user();
    if (!boula()) {
        $query->whereJsonContains('employees', (int) $user->employee_id);
    }

    // --- Status filter (0 = live, 1 = finished) ---
    if ($request->has('status')) {
        $query->where('status', $request->status);
    }

    // --- Text search (title) ---
    if ($request->filled('search')) {
        $search = $request->search;
        $query->where('title', 'LIKE', "%{$search}%");
    }

    // --- Date range filter ---
    if ($request->filled('start_date')) {
        $query->where('date', '>=', $request->start_date);
    }
    if ($request->filled('end_date')) {
        $query->where('date', '<=', $request->end_date);
    }

    // --- Filter by employee IDs (JSON column) ---
    if ($request->filled('employees')) {
        $employeeIds = explode(',', $request->employees);
        $query->where(function ($q) use ($employeeIds) {
            foreach ($employeeIds as $empId) {
                $q->orWhereJsonContains('employees', (int) $empId);
            }
        });
    }

    // --- Filter by project IDs ---
    if ($request->filled('projects')) {
        $projectIds = explode(',', $request->projects);
        $query->whereIn('project_id', $projectIds);
    }

    // --- Only active (not soft-deleted) tasks ---
    $query->where('isActive', 1);



    // --- Paginate ---
    $tasks = $query->with('project')->paginate(20);

    // --- Format response ---
    $formatted = $tasks->getCollection()->map(function ($task) {
        return [
            'id'         => $task->id,
            'title'      => $task->title,
            'project'    => $task->project?->title ?? '',
            'project_id' => $task->project_id,
            'employee'   => $this->resolveEmployeeNames($task->employees),
            'employees'  => $task->employees,
            'date'       => $task->date,
            'created_at' => $task->created_at?->format('Y-m-d'),
            'piority'    => $task->piority,
            'status'     => $task->status,
            'isDeleted'  => $task->isActive == 0,
        ];
    });

    return response()->json([
        'status' => 200,
        'data'   => [
            'tasks'      => $formatted,
            'tasks_meta' => [
                'current_page' => $tasks->currentPage(),
                'last_page'    => $tasks->lastPage(),
                'total'        => $tasks->total(),
                'per_page'     => $tasks->perPage(),
            ],
        ],
    ]);
}

/**
 * Helper: resolve employee names from JSON column
 * employees column stores array of IDs: [1, 2, 3]
 */
private function resolveEmployeeNames($employees): string
{
    if (!$employees) return '';

    $ids = is_array($employees) ? $employees : json_decode($employees, true);
    if (empty($ids)) return '';

    return \App\Models\Admin::whereIn('id', $ids)
        ->pluck('name')
        ->implode(', ');
}


    public function stats($date = null)
    {

        // Use today's date if none is provided
        $date = request()->query('date') ? Carbon::parse(request()->query('date')) : Carbon::now();
        $startOfMonth = $date->copy()->startOfMonth();
        $endOfMonth = $date->copy()->endOfMonth();

        // Extract the year from the selected date
        $year = $date->year;

        // Initialize monthly income array
        $monthlyIncomeArray = [];

        $yearTotalIncome = 0;
        $yearTotalOutcome = 0;
        $monthlyProjectsArray = [];
        // Loop through each month (1 to 12)
        for ($month = 1; $month <= 12; $month++) {
            $startOfCurrentMonth = Carbon::createFromDate($year, $month, 1)->startOfMonth();
            $endOfCurrentMonth = Carbon::createFromDate($year, $month, 1)->endOfMonth();

            $monthlyIncome = Fee::where('amount', '>', 0)
                ->whereBetween('created_at', [$startOfCurrentMonth, $endOfCurrentMonth])
                ->sum('amount');

            $monthlyOutcome = Fee::where('amount', '<', 0)
                ->whereBetween('created_at', [$startOfCurrentMonth, $endOfCurrentMonth])
                ->sum('amount');

            $monthlyProjects = Project::whereBetween('created_at', [$startOfCurrentMonth, $endOfCurrentMonth])->where("cost", ">", 0)->count();
            $allProjects = Project::where("cost", ">", 0)->count();


            $monthlyIncomeArray[] = $monthlyIncome; // You can round() if needed
            $yearTotalIncome += $monthlyIncome; // You can round() if needed
            $monthlyOutcomeArray[] = $monthlyOutcome * -1; // You can round() if needed
            $yearTotalOutcome += $monthlyOutcome * -1; // You can round() if needed
            $monthlyProjectsArray[] = $monthlyProjects; // Add this line
        }

        // Monthly stats for selected month
        $avgFees = Fee::whereBetween('created_at', [$startOfMonth, $endOfMonth])->sum('amount');
        $incomeFees = Fee::where('amount', '>', 0)->whereBetween('created_at', [$startOfMonth, $endOfMonth])->sum('amount');
        $outcomeFees = Fee::where('amount', '<', 0)->whereBetween('created_at', [$startOfMonth, $endOfMonth])->sum('amount');

        // All-time stats
        $allavgFees = Fee::sum('amount');
        $allincomeFees = Fee::where("amount", ">", 0)->sum('amount');
        $alloutcomeFees = Fee::where("amount", "<", 0)->sum('amount');

        // Retrieve and filter projects
        $projects = Project::latest()->get();
        $selectedProjects = $projects->filter(function ($project) {
            return rest($project) > 0 || ($project->status == 2 && $project->cost != 0);
        })->sortByDesc(fn($project) => rest($project));

        $dueMoneyProjects = $projects->filter(function ($project) {
            return rest($project) > 0 && $project->status == 2;
        })->sortByDesc(fn($project) => rest($project));

        // Total of rest
        $totalRest = $selectedProjects->sum(fn($project) => rest($project));

        $totalDueRest = $dueMoneyProjects->sum(fn($project) => rest($project));
        $totalFutureRest = $totalRest - $totalDueRest;

        // Total of project cost
        $totalCost = $selectedProjects->sum('cost');
        // Get all projects once
        $boardProjects = Project::get();



        // Contract projects (status = 2 but cost = 0)
        $contractProjects = $boardProjects->filter(function ($project) {
            return $project->status == 2 && $project->cost == 0;
        });
        // Projects with status = 2 (money projects)
        $moneyProjects = $boardProjects->filter(function ($project) {
            return $project->status == 2 && $project->cost > 0;
        });

        $moneyProjectIds = Project::where('status', 2)
            ->where('cost', '>', 0)
            ->pluck('id'); // returns a collection of IDs


        $moneyProjectsList = $selectedProjects->filter(function ($project) use ($moneyProjectIds) {
            return $moneyProjectIds->contains($project->id);
        });

        // Progress projects (status = 1)
        $progressProjects = $boardProjects->filter(function ($project) {
            return $project->status == 1;
        });

        // Finished projects (status = 0)
        $finishedProjects = $boardProjects->filter(function ($project) {
            return $project->status == 0;
        });
        $colors = [
            "#FF6384",
            "#36A2EB",
            "#FFCE56",
            "#4BC0C0",
            "#9966FF",
            "#FF9F40",
            "#C9CBCF",
            "#8A2BE2",
            "#00FF7F",
            "#FF4500"
        ];

        $projectTrackCounts = Clienttrack::join('projects', 'clienttracks.project_id', '=', 'projects.id')
            ->where('clienttracks.created_at', '>=', $date) // 👈 filter by date
            ->select('projects.id as project_id', 'projects.title', DB::raw('COUNT(clienttracks.id) as total_tracks'))
            ->groupBy('projects.id', 'projects.title')
            ->having('total_tracks', '>', 0)
            ->get()
            ->map(function ($project, $index) use ($colors) {
                $project->color = $colors[$index % count($colors)]; // loop colors if more projects
                return $project;
            });


        // Prepare response data
        $data = [
            "projects" => ProjectResource::collection($selectedProjects),
            "boardProjects" => ProjectResource::collection(
                Project::latest()->get()->sortByDesc(fn($project) => rest($project))
            ),
            "conMoneyProjects" => ProjectResource::collection(
                Project::get()
                    ->filter(fn($project) => $project->status == 2 || $project->deal == 0)->sortByDesc(fn($project) => $project->status)
            ),
            "renewalProjects" => ProjectResource::collection(
                Project::whereNotNull('renewalDate')
                    ->orderBy('renewalDate', 'asc')->whereDate('renewalDate', '<=', Carbon::now()->addWeek())
                    ->get()
            ),
            "taskProjects" => ProjectResource::collection(
                Project::withCount([
                    'tasks as pending_tasks_count' => function ($q) {
                        $q->where('status', 0)
                            ->select(DB::raw('COUNT(DISTINCT title)'));
                    }
                ])
                    ->latest()
                    ->get()
                    ->filter(fn($p) => rest($p) > 0) // ✅ filter in PHP
                    ->sortByDesc('pending_tasks_count')
            ),

            "deadlineProjects" => ProjectResource::collection(
                Project::whereNotNull('deadline')
                    ->whereDate('deadline', '>=', now())
                    ->whereHas('tasks', fn($q) => $q->where('status', 0))
                    ->orderBy('deadline')
                    ->get()
                    ->filter(fn($p) => rest($p) > 0) // ✅ filter in PHP
            ),
            "avgFees" => $avgFees,
            "incomeFees" => $incomeFees,
            "outcomeFees" => $outcomeFees,
            "allavgFees" => $allavgFees,
            "alloutcomeFees" => $alloutcomeFees * -1,
            "allincomeFees" => $allincomeFees,
            "yearTotalIncome" => $yearTotalIncome,
            "yearTotalOutcome" => $yearTotalOutcome,
            "monthlyIncomeArray" => $monthlyIncomeArray,
            "monthlyOutcomeArray" => $monthlyOutcomeArray,
            "monthlyProjectsArray" => $monthlyProjectsArray,
            "moneyProjectIds" => $moneyProjectIds,
            "allProjects" => $allProjects,
            "pieCostProjects" => ProjectResource::collection(Project::where("cost", ">", 0)->orderBy("cost", "desc")->take(15)->get()),
            "last_time" => setting()->last_time . ' ' . getTimeAgo(setting()->last_time),
            "allowedIn" => date('Y-m-d', strtotime(setting()->last_time . ' + 3 days')),
            "deadlineAction" => activeDeadline()["action"],
            "deadlineDate" => activeDeadline()["deadline"],
            "totalRest" => $totalRest,
            "totalGained" => $totalCost - $totalRest,
            "totalDueRest" => $totalDueRest,
            "totalFutureRest" => $totalFutureRest,
            "target" => settings()->target,
            "contractProjects" => count($contractProjects),
            "moneyProjectsListCount" > count($moneyProjectsList),
            "contracts" => $contractProjects,
            "moneyProjects" => count($moneyProjects),
            "progressProjects" => count($progressProjects),
            "finishedProjects" => count($finishedProjects),
            "isExpired" => isExpired()[0],
            "clientsCount" => count(Admin::where("type", "client")->get()),
            "prospectivesCount" => count(Admin::where("type", "prospective")->get()),
            "projectTrackCounts" => $projectTrackCounts,
        ];


        return successResponse($data);
    }






    public function store(TaskRequest $request)
    {
        try {

            $overthinkingTasks = Task::where("isOverthinking", 1)->get();
            $tasks = Task::get();

            if (count($tasks) == count($overthinkingTasks) && !isWithinWorkingHours())
                return failedResponse([]);

            $titles = explode('+', $request->title);
            foreach ($titles as $title) {
                Task::create([
                    'title' => $title,
                    'admin_id' => 1,
                    'project_id' => $request->project_id,
                    'piority' => 0,
                    'employees' => json_encode($request->employees),
                ]);
                
            }


            $data = [];

            return successResponse($data);
        } catch (Exception $e) {
            DB::table('tracks')->insert(['dispatch_status' => 'showing data of ' . json_encode($e->getMessage()), 'created_at' => now(),]);
            return redirect()->back()->with(['error' => __('general.something_wrong')]);
        }
    }
    public function refproPost(Request $request)
    {
        try {
            if (!isWithinWorkingHours()) {
                return failedResponse([]);
            }

            if (isset($request->project_id)) {
                $result = Project::find($request->project_id);
                $data['codeLinks'] = $request->title;
                $result->update($data);
            } else if (isset($request->refrence_id)) {
                $result = Issue::find($request->refrence_id);
                $result->update(["codeLinks" => $request->title]);
            }

            $data = ["result" => $result->codeLinks, "project" => $result];

            return successResponse($data);
        } catch (Exception $e) {
            DB::table('tracks')->insert(['dispatch_status' => 'showing data of ' . json_encode($e->getMessage()), 'created_at' => now(),]);
            dd($e->getMessage());
            return redirect()->back()->with(['error' => __('general.something_wrong')]);
        }
    }


    public function refproGet(Request $request)
    {
        try {
            if (!isWithinWorkingHours()) {
                return failedResponse([]);
            }

            if (isset($request->project_id)) {
                $result = Project::find($request->project_id);
            } else if (isset($request->refrence_id)) {
                $result = Issue::find($request->refrence_id);
            }

            $data = ["result" => $result->codeLinks, "project" => $result];

            return successResponse($data);
        } catch (Exception $e) {
            DB::table('tracks')->insert(['dispatch_status' => 'showing data of ' . json_encode($e->getMessage()), 'created_at' => now(),]);
            dd($e->getMessage());
            return redirect()->back()->with(['error' => __('general.something_wrong')]);
        }
    }

    public function togglePiority($id)
    {
        try {

            if (!isWithinWorkingHours())
                return failedResponse([]);

            // Find and toggle the level for the given task ID
            $task = Task::find($id);
            $priority=$task->piority;

            if (!$priority) {
                Deadline::updateOrCreate(
                    [
                        'title' => $task->title . " in " . $task->project->title,
                        'deadlineable_id' => $task->id,
                        'deadlineable_type' => Task::class,
                    ],
                    [
                        'date' => Carbon::now()->addDay()->toDateString(),
                        'isActive' => 1,
                    ]
                );

            $task->update(['piority' => !$priority]);

            }else{
                $deadline=Deadline::where("deadlineable_type",Task::class)->where("deadlineable_id",$task->id)->first();
                if($deadline && $deadline->status==0){
               return response()->json([
    'status' => false,
    'message' => 'Delete it from deadlines first'
], 400);

                }else{
                   $task->update(['piority' => !$priority]);

                }

            }




            return response()->json(['success' => __('general.changed_successfully' . $task->piority)]);
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()]);
        }
    }
public function toggleStatus($id)
{
    try {

        if (!isWithinWorkingHours())
            return failedResponse([]);

        $task = Task::findOrFail($id);

        // Toggle task status
        $newStatus = !$task->status;
        $task->update(['status' => $newStatus]);

        // ✅ If task has linked deadline → update its status too
        $deadline = Deadline::where('deadlineable_type', Task::class)
            ->where('deadlineable_id', $task->id)
            ->first();

        if ($deadline) {
            $deadline->update([
                'status' => $newStatus
            ]);
        }

        return successResponse($task);

    } catch (Exception $e) {
        return response()->json(['error' => $e->getMessage()]);
    }
}


    public function links($id)
    {
        try {

            if (boula())
                $links = Navigation::where("category_id", $id)->orderBy('title', 'asc')->get();
            else
                $links = [];
            $data["links"] = NavigationResource::collection($links);
            $data["isExpired"] = isExpired()[0];
            return successResponse($data);
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()]);
        }
    }

    public function lock()
    {
        try {
            // $deals = Deal::latest()->get();

            // Get today's and tomorrow's dates
            $today = Carbon::today('Africa/Cairo');
            $tomorrow = Carbon::tomorrow('Africa/Cairo');

            // Only deadlines with date today or tomorrow
            $deadlines = Deadline::where("status", 0)
                ->whereDate('date', '<', $tomorrow) // all deadlines before tomorrow
                ->latest()
                ->get();

            // $tasks = Task::where("status", 0)->where("piority", 1)
            //     ->latest()
            //     ->get();

            $locks = [];

            // foreach ($deals as $deal) {
            //     $locks[] = "Get".$deal->cost." ".$deal->project->title;
            // }
            foreach ($deadlines as $deadline) {
                $locks[] = $deadline->title;
            }
            // foreach ($tasks as $task) {
            //     $locks[] = $task->title." in ".$task->project->title;
            // }

            $data["lock"] = $locks;
            $data["isExpired"] = isExpired()[0];

            return successResponse($data);
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()]);
        }
    }




public function elements($id, Request $request)
{
    try {

        $category = Category::withoutGlobalScopes()->findOrFail($id);

        if (!$category->model) {
            return response()->json(['error' => 'Model not defined'], 400);
        }

        if (!class_exists($category->model)) {
            return response()->json([
                'error' => 'Model class not found',
                'model' => $category->model
            ], 400);
        }
        $model = $category->model;
        $searchKeys = $category->search_keys ?? [];
        $titleField = 'id';
        $configClass = $category->config_class ?? \App\CategoryConfigs\BaseCategoryConfig::class;

        if (!class_exists($configClass)) {
            return response()->json(['error' => 'Invalid config class'], 400);
        }

        // Ensure keys are arrays
        if (is_string($searchKeys)) $searchKeys = array_map('trim', explode(',', $searchKeys));

        // Eager load relations used in search/filter keys
        $relations = [];
        foreach ($searchKeys as $key) {
            $parts = explode('.', $key);
            if (count($parts) > 1) $relations[] = $parts[0];
        }
        $relations = array_unique($relations);

        $query = $model::with($relations)->latest()->withoutGlobalScopes();

        /*
        |----------------------------------------------------------------------
        | Date Filter
        |----------------------------------------------------------------------
        */
        if ($request->from) $query->whereDate('created_at', '>=', $request->from);
        if ($request->to) $query->whereDate('created_at', '<=', $request->to);

        /*
        |----------------------------------------------------------------------
        | Dynamic Exact Filters
        |----------------------------------------------------------------------
        */


        /*
        |----------------------------------------------------------------------
        | Dynamic Search
        |----------------------------------------------------------------------
        */
        if ($request->search) {
            $values = array_filter(array_map('trim', explode(',', $request->search)));
            $configClass::applySearch($query, $values, $searchKeys);
        }

        $items = $query->paginate($request->per_page ?? 20);

        /*
        |----------------------------------------------------------------------
        | Dynamic Transform + extra field
        |----------------------------------------------------------------------
        */
        $items->getCollection()->transform(function ($item) use ($configClass, $titleField, $searchKeys) {

            $transformed = $configClass::transform($item, $titleField);

            // Concatenate all search/filter key values into 'extra'
            $extraValues = [];

            foreach ($searchKeys as $key) {
                $key = trim($key);
                $value = data_get($item, $key);
                if ($value !== null && $value !== '') {
                    $extraValues[] = $value;
                }
            }

            $transformed['extra'] = implode(', ', $extraValues);

            return $transformed;
        });

        return response()->json([
            "status" => 200,
            "message" => "success",
            "data" => [
                "elements" => $items
            ]
        ]);

    } catch (\Exception $e) {

        return response()->json([
            "status" => 500,
            "message" => $e->getMessage()
        ]);
    }
}


    public function deadlines()
    {
        try {

            $deadlines = Deadline::where("status", 0)->orderBy("date", "asc")->get();
            $data["deadlines"] = $deadlines;
            $data["isExpired"] = isExpired()[0];
            if (boula())
                return successResponse($data);
            else
                return successResponse([]);
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()]);
        }
    }
    public function bases()
    {
        try {

            $bases = Base::get();
            $data["bases"] = $bases;
            $data["isExpired"] = isExpired()[0];
            return successResponse($data);
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()]);
        }
    }



    public function updateDeadline(Request $request)
    {
        try {
            $deadline = Deadline::find($request->id);
            if ($request->action == "delete"){

                if ($deadline->isForever) {
                    return successResponse([], "Deadline is forever!", 201);
                } else {

                    // Toggle deadline status
                    $deadline->update([
                        "status" => !$deadline->status,
                    ]);

                    // If linked to Task
                    if ($deadline->deadlineable_type === Task::class && $deadline->deadlineable_id) {

                        $task = Task::find($deadline->deadlineable_id);

                        if ($task) {
                            $task->update([
                                'status' => $deadline->status,
                            ]);
                        }
                    }

                    // If linked to Deal AND status became 1
                    if (
                        $deadline->deadlineable_type === Deal::class &&
                        $deadline->deadlineable_id &&
                        $deadline->status == 1
                    ) {
                        $deal = Deal::find($deadline->deadlineable_id);

                        if ($deal) {
                            $deal->update(["isPaid"=>1]);
                        }
                    }
                }


            }
            else if (isset($request->date))
                $deadline->update(["date" => $request->date, "title" => isset($request->title) ? $request->title : $deadline->title]);

            $deadlines = Deadline::orderBy("date", "asc")->get();


            $data = ["boardProjects" => $deadlines, "action" => $request->action];

            return successResponse($data);
        } catch (Exception $e) {
            DB::table('tracks')->insert(['dispatch_status' => 'showing data of ' . json_encode($e->getMessage()), 'created_at' => now(),]);
            return failedResponse($e->getMessage());
        }
    }

    public function updateProjectDeadline(Request $request)
    {
        try {

            DB::table('tracks')->insert(['dispatch_status' => 'showing data of ' . json_encode($request->all()), 'created_at' => now(),]);
            $deadline = Project::find($request->id);

            $deadlineTime = Carbon::parse($request->date, 'UTC')->setTimezone('Africa/Cairo');
            $deadline->update(["deadline" => $deadlineTime]);

            $deadlines = Project::orderBy("deadline", "asc")->get();


            $data = ["boardProjects" => ProjectResource::collection(
                Project::orderBy("deadline", "asc")
                    ->get()
                    ->filter(fn($project) => $project->status != 1)
            )];

            return successResponse($data);
        } catch (Exception $e) {
            DB::table('tracks')->insert(['dispatch_status' => 'showing data of ' . json_encode($e->getMessage()), 'created_at' => now(),]);
            return failedResponse($e->getMessage());
        }
    }




    public function storeDeadline(Request $request)
    {
        try {
            if (boula())
                $deadline = Deadline::create(["title" => $request->title, "date" => $request->date]);

            $deadlines = Deadline::orderBy("date", "asc")->get();


            $data = ["deadlines" => $deadlines, "action" => $request->action];

            return successResponse($data);
        } catch (Exception $e) {
            return failedResponse($e->getMessage());
        }
    }






    public function track(Request $request)
    {

        try {

            $data = [];

            DB::table('tracks')->insert(['dispatch_status' => 'showing data of ' . json_encode(request()->all()), 'created_at' => now(), 'updated_at' => now(),]);

            return response()->json([
                'message' => 'User successfully registered',
                'user' => $data
            ], 201);
        } catch (Ecxception $e) {
            dd($e->getMessage());
        }
    }

    public function hollyMass()
    {

        try {
            if (boula()) {

                $hollyMass = Issue::where("id", 66)->first();


                return response()->json([
                    'message' => 'User is Boula',
                    'data' => $hollyMass
                ], 201);
            }
        } catch (Ecxception $e) {
            dd($e->getMessage());
        }
    }


    public function boardProjects()
    {



        return successResponse(["boardProjects" => ProjectResource::collection(
            Project::orderBy("deadline", "asc")
                ->get()
                ->filter(fn($project) => $project->status == 1 || $project->status == 2)
        ),]);
    }
    public function info()
    {
            $infoProjects = Project::orderBy("title", "asc")
                ->get();
            $issues = Issue::orderBy("title", "asc")->get();

        return successResponse([
            "infoProjects" => ProjectResource::collection($infoProjects),
            "refrences" => IssueResource::collection($issues),
        ]);
    }



public function updatedSelectedDeadlines(Request $request)
{
    $request->validate([
        'ids'  => 'required|array|min:1',
        'ids.*'=> 'integer|exists:deadlines,id',
        'date' => 'required|date',
    ]);

    $date = Carbon::parse($request->date)->toDateString();

    Deadline::query()
        ->whereIn('id', $request->ids)
        ->where('status', 0) // only unfinished
        ->update([
            'date' => $date,
            'updated_at' => now(),
        ]);

    return successResponse([]);
}


public function createLastRepeatTime(Request $request)
{
    $request->validate([
        'date' => 'required|date',
    ]);

    $date = Carbon::parse($request->date)->toDateString();

    Repeat::create([
        'date' => $date,
        'created_at' => now(),
        'updated_at' => now(),
        ]);

    return successResponse([]);
}


public function lastRepeatTime(Request $request)
{
    $lastRepeat = Repeat::latest()->first();

    return successResponse([
        "lastRepeat" => $lastRepeat
            ? Carbon::parse($lastRepeat->date)
                ->timezone('Africa/Cairo')
                ->toDateString() // YYYY-MM-DD
            : null
    ]);
}



public function bulkDelete(Request $request)
{
    $request->validate([
        'task_ids'   => 'required|array|min:1',
        'task_ids.*' => 'integer|exists:tasks,id',
    ]);

    $adminId = auth("api")->user()->id;

    $tasks = Task::whereIn('id', $request->task_ids)->get();

    foreach ($tasks as $task) {
        $task->status     = $task->status == 1 ? 0 : 1;
        $task->admin_id   = $adminId;
        $task->updated_at = now();
        $task->save();
    }

    return response()->json([
        'status'  => 200,
        'message' => count($tasks) . " task(s) toggled successfully.",
        'data'    => [
            'affected' => count($tasks),
            'tasks' => $tasks->map(fn($t) => [
                'id'       => $t->id,
                'status'   => $t->status,
            ]),
        ],
    ]);
}

/**
 * Bulk assign employees to tasks
 * POST /api/apptask/bulk-assign
 * Body: { "task_ids": [1, 2], "employee_ids": [5, 6] }
 */
public function bulkAssign(Request $request)
{
    $request->validate([
        'task_ids'      => 'required|array|min:1',
        'task_ids.*'    => 'integer|exists:tasks,id',
        'employee_ids'  => 'required|array|min:1',
        'employee_ids.*'=> 'integer',
    ]);

    // employees column is JSON — we set (or merge) the new employee list
    $tasks = Task::whereIn('id', $request->task_ids)->get();

    foreach ($tasks as $task) {
        $employees    = $request->employee_ids;

        $task->employees   = json_encode($employees);
        $task->admin_id    = auth("api")->user()->id;
        $task->updated_at  = now();
        $task->save();
    }

    return response()->json([
        'status'  => 200,
        'message' => count($tasks) . " task(s) assigned successfully.",
        'data'    => ['affected' => count($tasks)],
    ]);
}

/**
 * Bulk update the date field on tasks
 * POST /api/apptask/bulk-update-date
 * Body: { "task_ids": [1, 2], "date": "2026-04-01" }
 */
public function bulkUpdateDate(Request $request)
{
    $request->validate([
        'task_ids'   => 'required|array|min:1',
        'task_ids.*' => 'integer|exists:tasks,id',
        'date'       => 'required|date_format:Y-m-d',
    ]);

    $updated = Task::whereIn('id', $request->task_ids)
        ->update([
            'date'       => $request->date,
            'admin_id'   => auth("api")->user()->id,
            'updated_at' => now(),
        ]);

    return response()->json([
        'status'  => 200,
        'message' => "$updated task(s) date updated to {$request->date}.",
        'data'    => ['affected' => $updated, 'date' => $request->date],
    ]);
}

}
