<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\TaskRequest;
use App\Http\Resources\ProjectResource;
use App\Http\Resources\NavigationResource;
use App\Http\Resources\IssueResource;
use App\Http\Resources\TaskResource;
use App\Http\Resources\PhoneGigResource;
use App\Http\Resources\PostGigResource;
use App\Http\Resources\DealResource;
use App\Http\Resources\PostResource;
use App\Models\KitTool;
use App\Models\Query;
use App\Models\Project;
use App\Models\phoneGig;
use App\Models\postGig;
use App\Models\CallHistory;
use App\Models\Issue;
use App\Models\Overtime;
use App\Models\Fear;
use App\Models\Marketting;
use App\Models\Repeat;
use App\Models\Fee;
use App\Models\Note;
use App\Models\Admin;
use App\Models\Deadline;
use App\Models\Category;
use App\Models\Video;
use App\Models\Projecthour;
use App\Models\Base;
use App\Models\Navigation;
use App\Models\Clienttrack;
use App\Models\Task;
use App\Models\DailyWork;
use App\Models\DBCredential;
use App\Models\Deal;
use App\Models\Survey;
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
        ->whereNotIn("type", ["client", "prospective"])
        ->select('admins.*')
        ->selectRaw("(
            SELECT COUNT(*) FROM tasks
            WHERE tasks.status = 0
            AND JSON_CONTAINS(tasks.employees, CAST(admins.id AS JSON))
        ) as active_tasks_count")
        ->orderBy('name')
        ->get();

    if (auth("api")->user()->email == "parcel@gmail.com") {
        $employees = Admin::where("email", auth("api")->user()->email)->get();
    }

    $clients = Admin::where("isActive", 1)->where("type", "client")->orderBy('name')->get();
    $prospectives = Admin::where("isActive", 1)->where("type", "prospective")->orderBy('name')->get();

    // --- Projects ---
    if (auth("api")->user()->email == "parcel@gmail.com") {
        $projects = Project::withoutGlobalScope('excludePersonal')
            ->where("title", "Parcel Express")
            ->orderBy("title")
            ->get();
    } else {
        $projects = Project::withoutGlobalScope('excludePersonal')->where("appearance",1)
            ->orderBy("title")
            ->get();
    }

    // ✅ USE SHARED FILTER
    $tasks = Task::filter($request, [
        'ignore_user_scope' => false 
    ])->paginate(20);

    return successResponse([
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
    ]);
}

public function tasks(Request $request)
{
    $tasks = Task::with('project')
        ->filter($request)
        ->paginate(20);

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
            'isFixed'    => $task->isFixed,
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
    if (empty($employees)) return '';

    // Normalize to array
    if (is_string($employees)) {
        $employees = json_decode($employees, true);
    }

    if (empty($employees) || !is_array($employees)) return '';

    // Filter out any null/invalid IDs before querying
    $ids = array_filter($employees, fn($id) => is_numeric($id));

    if (empty($ids)) return '';

    return \App\Models\Admin::whereIn('id', $ids)
        ->orderBy('name')               // consistent ordering
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
                    'date' => $request->deadline,
                    'piority' => 0,
                    'employees' => $request->employees,
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
                $data['ai_prompt'] = $request->title;
                $result->update($data);
            } else if (isset($request->refrence_id)) {
                $result = Issue::find($request->refrence_id);
                $result->update(["ai_prompt" => $request->title]);
            }

            $data = ["result" => $result->ai_prompt, "project" => $result];

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

            $data = ["result" => $result->ai_prompt, "project" => $result];

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

        if ($task->isFixed)
            return failedResponse([]);

        // Toggle task status
        $newStatus = !$task->status;
        $task->update(['status' => $newStatus]);

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
        if (!boula()) {
            return successResponse([
                "lock"      => [],
                "isExpired" => isExpired()[0],
            ]);
        }

        $tasks = Task::where("status", 0)
            ->orderBy("date", "asc") // ✅ soonest first instead of latest
            ->get();

        $locks = [];

        foreach ($tasks as $task) {
            $locks[] = $task->title . " in " . $task->project->title;
        }

        return successResponse([
            "lock"      => $locks,
            "isExpired" => isExpired()[0],
        ]);

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


    public function facebookAds()
    {

        try {
            if (boula()) {

                $facebookAds = Issue::where("id", 118)->first();


                return response()->json([
                    'message' => 'User is Boula',
                    'data' => $facebookAds
                ], 201);
            }
        } catch (Ecxception $e) {
            dd($e->getMessage());
        }
    }


    public function boardProjects()
    {

   $admins=Admin::all();

        return successResponse(["boardProjects" => ProjectResource::collection(
            Project::orderBy("deadline", "asc")->where("appearance",1)->get()
        ),"admins"=>$admins]);
    }
    public function info()
    {
        $infoProjects = Project::orderBy("title", "asc")->get();
        
        // If not boula, return empty collection for issues
        if (!boula()) {
            $issues = collect(); // Empty collection
        } else {
            $issues = Issue::orderBy("title", "asc")->get();
        }

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
        // isFixed tasks are locked at status = 0
        if ($task->isFixed) {
            continue;
        }

        $task->status     = $task->status == 1 ? 0 : 1;
        $task->admin_id   = $adminId;
        $task->updated_at = now();
        $task->save();
    }

    $affected = $tasks->where('isFixed', 0)->count();

    return response()->json([
        'status'  => 200,
        'message' => "$affected task(s) toggled successfully.",
        'data'    => [
            'affected' => $affected,
            'skipped'  => $tasks->where('isFixed', 1)->count(), // how many were locked
            'tasks'    => $tasks->map(fn($t) => [
                'id'      => $t->id,
                'status'  => $t->status,
                'isFixed' => $t->isFixed,
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
        'task_ids'       => 'required|array|min:1',
        'task_ids.*'     => 'integer|exists:tasks,id',
        'employee_ids'   => 'required|array|min:1',
        'employee_ids.*' => 'integer|exists:admins,id',
    ]);

    $affected = Task::whereIn('id', $request->task_ids)->update([
        'employees' => json_encode($request->employee_ids), // raw update needs manual encode
        'admin_id'  => auth('api')->user()->id,
    ]);

    return response()->json([
        'status'  => 200,
        'message' => "$affected task(s) assigned successfully.",
        'data'    => ['affected' => $affected],
    ]);
}


public function bulkAssignProject(Request $request)
{
    Task::whereIn('id', $request->task_ids)
        ->update(['project_id' => $request->project_id]);

    return response()->json(['status' => 200, 'message' => 'Project assigned']);
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



public function createPost(Request $request)
{
    $post = Marketting::create([
        "text" => $request->text,
    ]);
    
    // Handle base64 images
    if ($request->has('images') && is_array($request->images)) {
        foreach ($request->images as $imageData) {
            // Get base64 data
            $base64 = $imageData['base64'];
            $filename = $imageData['name'] ?? uniqid() . '.jpg';
            $mimeType = $imageData['type'] ?? 'image/jpeg';
            
            // Remove data:image/jpeg;base64, prefix if present
            if (strpos($base64, 'base64,') !== false) {
                $base64 = explode('base64,', $base64)[1];
            }
            
            // Decode base64
            $imageBinary = base64_decode($base64);
            
            // Generate unique filename
            $uniqueFilename = uniqid() . '_' . $filename;
            $path = 'images/' . $uniqueFilename;
            
            // Create a temporary file
            $tempPath = tempnam(sys_get_temp_dir(), 'img');
            file_put_contents($tempPath, $imageBinary);
            
            // Create a new file instance
            $file = new \Illuminate\Http\UploadedFile(
                $tempPath,
                $filename,
                $mimeType,
                null,
                true
            );
            
            // Move the file using your existing method
            $file->move('images', $uniqueFilename);
            
            // Create file record
            $post->files()->create(['url' => $path]);
            
            // Clean up temp file
            if (file_exists($tempPath)) {
                unlink($tempPath);
            }
        }
    }
    
    return successResponse($post);
}
public function getPosts(Request $request)
{
    $query = Marketting::orderBy("created_at", "desc");
    
    // Filter by text if provided
    if ($request->has('search') && !empty($request->search)) {
        $query->where('text', 'like', '%' . $request->search . '%');
    }
    
    // Paginate results (10 posts per page)
    $posts = $query->paginate(2);
    
    // Return the paginator directly with resources
    return successResponse(PostResource::collection($posts->items()), $posts);
}
public function deletePost($id){
    $post=Marketting::find($id);
    $post->deleteFiles();
    $post->delete();
    return successResponse($post);
}


public function offlineTasks(Request $request)
{
    // Apply the same filter logic as in create() function
    $tasks = Task::filter($request, [
        'ignore_user_scope' => false 
    ])->orderBy("date", "asc") 
      ->where("status", 0)
      ->get();
    
    // Return the tasks with success response
    return successResponse(TaskResource::collection($tasks));
}
public function offlineNotes(Request $request)
{
    if (!boula()) {
        return successResponse([]);
    }
    
    $notes = Note::inRandomOrder()->take(300)->get();
    return successResponse($notes);
}
public function settings(Request $request)
{
    $settings = setting();
    return successResponse($settings);
}
public function competitors(Request $request)
{
    $competitors = Navigation::where('category_id', 25)->get();
    return successResponse($competitors);
}
public function jobs(Request $request)
{
    $jobs = Navigation::where('category_id', 5)->get();
    return successResponse($jobs);
}

public function marketingTools(Request $request)
{
    $tools = Navigation::where('category_id', 26)->get();
    return successResponse($tools);
}

public function addProjectHours(Request $request)
{
    $request->validate([
        'project_id' => 'required|exists:projects,id',
        'admin_id' => 'required|exists:admins,id',
        'hours'      => 'required|numeric',
    ]);

    $projectHour = Projecthour::create([
        'project_id' => $request->project_id,
        'hours_count'      => $request->hours,
        'employee_id'   => $request->admin_id,
    ]);

    return successResponse($projectHour);
}
public function addPhoneGig(Request $request)
{
    $request->validate([
        'phone'      => 'required|string|unique:phone_gigs,phone',
        'description' => 'nullable|string',
    ]);

    $phoneGig = phoneGig::create([
        'phone' => $request->phone,
        'description' => $request->description,
    ]);

    return successResponse($phoneGig);
}
public function addPostGig(Request $request)
{
    $request->validate([
        'post_link' => 'required|string',
        'description' => 'nullable|string',
    ]);

    $postGig = postGig::create([
        'post_link' => $request->post_link,
        'description' => $request->description,
    ]);

    return successResponse($postGig);
}
public function addCallHistory(Request $request)
{
    $request->validate([
        'phone_gig_id' => 'required|exists:phone_gigs,id',
    ]);

    $callHistory = CallHistory::create([
        'phone_gig_id' => $request->phone_gig_id,
    ]);

    return successResponse($callHistory);  // ✅ Return the correct variable
}

public function getAllPhoneGigs()
{
    $phoneGigs = phoneGig::latest()->get();
    return successResponse(PhoneGigResource::collection($phoneGigs));
}
public function getAllPostGigs()
{
    $postGigs = postGig::latest()->get();
    return successResponse(PostGigResource::collection($postGigs));
}


public function updateTasksToToday()
{
    $tasks = Task::where('status', 0)->where('date', '<', today())
        ->update(['date' => today()]);

    return successResponse($tasks);
}


public function surveies()
{
    $surveies = Survey::query()
        ->where('isActive', 1)
        ->get()
        ->groupBy('parent')
        ->map(function ($group) {
            return $group->random(1)->first();
        })
        ->values();

    return successResponse($surveies);
}


}