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
use App\Models\LinkHistory;


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

        $destinationPath = public_path('uploads/tasks');
        if (! file_exists($destinationPath)) {
            mkdir($destinationPath, 0755, true);
        }

        // Move uploaded files once, collect their stored relative paths.
        // (Same files get attached to every task created from this request,
        // matching how the app groups images per task-form.)
        $storedFilePaths = [];
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $file) {
                if (! $file instanceof \Illuminate\Http\UploadedFile || ! $file->isValid()) {
                    continue;
                }

                $fileName = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
                $file->move($destinationPath, $fileName);

                $storedFilePaths[] = 'uploads/tasks/' . $fileName;
            }
        }

        $titles = explode('+', $request->title);
        $createdTasks = [];

        foreach ($titles as $title) {
            $title = trim($title);

            if (empty($title))
                continue;

            $exists = Task::where('title', $title)
                ->where('project_id', $request->project_id)
                ->exists();

            if ($exists)
                continue;

            $newTask = Task::create([
                'title'      => $title,
                'admin_id'   => 1,
                'project_id' => $request->project_id,
                'date'       => $request->deadline,
                'piority'    => $request->piority ?? 0,
                'employees'  => $request->employees,
            ]);

            foreach ($storedFilePaths as $path) {
                $newTask->files()->create([
                    'url' => $path,
                ]);
            }

            $newTask->load('files');
            $newTask->images = $newTask->files->map(function ($file) {
                return asset($file->url);
            });

            $createdTasks[] = $newTask;
        }

        return successResponse($createdTasks);
    } catch (Exception $e) {
        DB::table('tracks')->insert([
            'dispatch_status' => 'showing data of ' . json_encode($e->getMessage()),
            'created_at'      => now(),
        ]);

        return response()->json([
            'status'  => 500,
            'message' => 'error',
            'error'   => $e->getMessage(),
        ], 500);
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
        'description' => 'required|string',
        'type' => 'required|string',
    ]);

    $phoneGig = phoneGig::create([
        'phone' => $request->phone,
        'description' => $request->description,
        "type" => $request->type,
    ]);

    return successResponse($phoneGig);
}
public function addPostGig(Request $request)
{
    $request->validate([
        'post_link' => 'required|string',
        'description' => 'required|string',
        'type' => 'required|string',
    ]);

    $postGig = postGig::create([
        'post_link' => $request->post_link,
        'description' => $request->description,
        "type" => $request->type,
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

public function getAllPhoneGigs(Request $request)
{
    $perPage = $request->get('per_page', 15);

    $phoneGigs = PhoneGig::select('phone_gigs.*')
        ->leftJoin(
            DB::raw('(SELECT phone_gig_id, MAX(created_at) as last_called_at FROM call_histories GROUP BY phone_gig_id) as ch'),
            'phone_gigs.id', '=', 'ch.phone_gig_id'
        )
        ->orderByRaw('ch.last_called_at IS NOT NULL ASC')
        ->orderBy('ch.last_called_at', 'ASC')
        ->paginate($perPage);

    return successResponse($phoneGigs);
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
        ->shuffle() // randomize final result
        ->take(5)   // take only 5
        ->values();

    return successResponse($surveies);
}


public function getRepeatSurveyMinuits()
{
    $data = setting()->repeat_survey_minuits;

    return successResponse([
        "repeat_survey_minuits" => $data
    ]);
}


public function asyncCreate(Request $request)
{
    $request->validate([
        'tasks'            => 'nullable|array',
        'notes'            => 'nullable|array',
        'phone_gigs'       => 'nullable|array',
        'post_gigs'        => 'nullable|array',
        'task_updates'     => 'nullable|array',
        'task_deletes'     => 'nullable|array',
        'task_assignments' => 'nullable|array',
        'surveys' => 'nullable|array',
    ]);

    // ── PRE-VALIDATE EVERYTHING BEFORE TOUCHING THE DB ────────────────────
    $errors = [];

    foreach ($request->tasks ?? [] as $index => $item) {
        if (empty(trim($item['title'] ?? '')))
            $errors[] = "tasks[$index]: title is required.";
    }

    foreach ($request->notes ?? [] as $index => $item) {
        if (empty(trim($item['title'] ?? '')))
            $errors[] = "notes[$index]: title is required.";
    }

    foreach ($request->phone_gigs ?? [] as $index => $item) {
        $phone = trim($item['phone'] ?? '');

        if (!$phone)
            $errors[] = "phone_gigs[$index]: phone is required.";
        elseif (phoneGig::where('phone', $phone)->exists())
            $errors[] = "phone_gigs[$index]: phone '$phone' already exists.";

        if (empty($item['description'] ?? ''))
            $errors[] = "phone_gigs[$index]: description is required.";

        if (empty($item['type'] ?? ''))
            $errors[] = "phone_gigs[$index]: type is required.";
    }

    foreach ($request->post_gigs ?? [] as $index => $item) {
        if (empty(trim($item['post_link'] ?? '')))
            $errors[] = "post_gigs[$index]: post_link is required.";

        if (empty($item['description'] ?? ''))
            $errors[] = "post_gigs[$index]: description is required.";

        if (empty($item['type'] ?? ''))
            $errors[] = "post_gigs[$index]: type is required.";
    }

    // Add to pre-validation loop
    foreach ($request->surveys ?? [] as $index => $item) {
        if (empty(trim($item['question'] ?? '')))
            $errors[] = "surveys[$index]: question is required.";
    }

    // Validate task updates (title/date/project/employees all optional, but at least one should exist)
    foreach ($request->task_updates ?? [] as $index => $item) {
        if (empty($item['task_id'])) {
            $errors[] = "task_updates[$index]: task_id is required.";
            continue;
        }

        // if (!Task::where('id', $item['task_id'])->exists()) {
        //     $errors[] = "task_updates[$index]: task not found.";
        //     continue;
        // }

        $hasTitle = array_key_exists('title', $item);
        $hasDate = array_key_exists('date', $item);
        $hasProject = array_key_exists('project_id', $item);
        $hasEmployees = array_key_exists('employees', $item);

        if (!$hasTitle && !$hasDate && !$hasProject && !$hasEmployees) {
            $errors[] = "task_updates[$index]: no updatable fields provided.";
        }

        if ($hasTitle && empty(trim($item['title'] ?? ''))) {
            $errors[] = "task_updates[$index]: title cannot be empty when provided.";
        }
    }

    // Validate task deletes
    foreach ($request->task_deletes ?? [] as $index => $item) {
        if (empty($item['task_id']))
            $errors[] = "task_deletes[$index]: task_id is required.";
        // elseif (!Task::where('id', $item['task_id'])->exists())
        //     $errors[] = "task_deletes[$index]: task not found.";
    }

    // Validate task assignments
    foreach ($request->task_assignments ?? [] as $index => $item) {
        if (empty($item['task_id'])) {
            $errors[] = "task_assignments[$index]: task_id is required.";
            continue;
        }

        // if (!Task::where('id', $item['task_id'])->exists()) {
        //     $errors[] = "task_assignments[$index]: task not found.";
        //     continue;
        // }

        if (empty($item['employee_ids']) || !is_array($item['employee_ids'])) {
            $errors[] = "task_assignments[$index]: employee_ids must be a non-empty array.";
        }
    }

    if (!empty($errors)) {
        return response()->json([
            'status'  => 422,
            'message' => 'Validation failed. Nothing was saved.',
            'errors'  => $errors,
        ], 422);
    }

    DB::beginTransaction();

    try {
        $created = [
            'tasks'      => [],
            'notes'      => [],
            'phone_gigs' => [],
            'post_gigs'  => [],
            'surveys'    => [],
        ];

        // SURVEYS
        foreach ($request->surveys ?? [] as $item) {
            $survey = \App\Models\Survey::create([
                'question' => trim($item['question']),
                'isActive' => $item['isActive'] ?? 1,
                'link'     => $item['link'] ?? null,
                'phone'    => $item['phone'] ?? null,
                'whatsapp' => $item['whatsapp'] ?? null,
            ]);

            $created['surveys'][] = [
                'temp_id' => $item['id'] ?? null,
                'real_id' => $survey->id,
            ];
        }

        // CREATE TASKS
        foreach ($request->tasks ?? [] as $item) {
            foreach (explode('+', $item['title']) as $title) {
                $title = trim($title);
                if (!$title) continue;

                $task = Task::create([
                    'title'      => $title,
                    'admin_id'   => auth('api')->id() ?? 1,
                    'project_id' => $item['project_id'] ?? null,
                    'employees'  => $item['employees'] ?? [],
                    'date'       => $item['date'] ?? null,
                    'piority'    => 0,
                ]);

                $created['tasks'][] = [
                    'temp_id' => $item['id'] ?? null,
                    'real_id' => $task->id,
                    'title'   => $task->title,
                ];
            }
        }

        // UPDATE TASKS (only update provided fields)
        foreach ($request->task_updates ?? [] as $item) {
            $task = Task::find($item['task_id']);
            if (!$task) continue;

            $payload = [];

            if (array_key_exists('title', $item))
                $payload['title'] = trim($item['title']);

            if (array_key_exists('date', $item))
                $payload['date'] = $item['date'];

            if (array_key_exists('project_id', $item))
                $payload['project_id'] = $item['project_id'];

            if (array_key_exists('employees', $item))
                $payload['employees'] = $item['employees'];

            if (!empty($payload))
                $task->update($payload);
        }

        // TASK ASSIGNMENTS
        foreach ($request->task_assignments ?? [] as $item) {
            $task = Task::find($item['task_id']);
            if (!$task) continue;

            $task->update([
                'employees' => $item['employee_ids'],
            ]);
        }

        // DELETE TASKS
        foreach ($request->task_deletes ?? [] as $item) {
            Task::where('id', $item['task_id'])->delete();
        }

        // NOTES
        foreach ($request->notes ?? [] as $item) {
            $note = Note::create([
                'title' => trim($item['title']),
            ]);

            $created['notes'][] = [
                'temp_id' => $item['id'] ?? null,
                'real_id' => $note->id,
            ];
        }

        // PHONE GIGS
        foreach ($request->phone_gigs ?? [] as $item) {
            $phoneGig = phoneGig::create([
                'phone'       => trim($item['phone']),
                'description' => $item['description'],
                'type'        => $item['type'],
            ]);

            $created['phone_gigs'][] = [
                'temp_id' => $item['id'] ?? null,
                'real_id' => $phoneGig->id,
            ];
        }

        // POST GIGS
        foreach ($request->post_gigs ?? [] as $item) {
            $postGig = postGig::create([
                'post_link'   => trim($item['post_link']),
                'description' => $item['description'],
                'type'        => $item['type'],
            ]);

            $created['post_gigs'][] = [
                'temp_id' => $item['id'] ?? null,
                'real_id' => $postGig->id,
            ];
        }

        DB::commit();

        return successResponse([
            'created' => $created,
        ]);
    } catch (Exception $e) {
        DB::rollBack();
        return failedResponse($e->getMessage());
    }
}


public function tasksByCredential(Request $request, $db_credential_id)
{
    try {
        $tasks = Task::with('project')
            ->where('status', 0)
            ->whereHas('project', function ($q) use ($db_credential_id) {
                $q->where('d_b_credential_id', $db_credential_id);
            })
            ->filter($request)
            ->orderByDesc('date')
            ->paginate($request->per_page ?? 7);

        $formatted = $tasks->getCollection()->map(function ($task) {
            return [
                'id'          => $task->id,
                'title'       => $task->title,
                'project'     => $task->project?->title ?? '',
                'project_id'  => $task->project_id,
                'employee'    => $this->resolveEmployeeNames($task->employees),
                'employees'   => $task->employees,
                'date'        => $task->date,
                'created_at'  => $task->created_at?->format('Y-m-d'),
                'piority'     => $task->piority,
                'status'      => $task->status,
                'isFixed'     => $task->isFixed,
                'images'     => $task->images,
            ];
        });

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

        return response()->json([
            'status' => 200,
            'data'   => [
                'employees'=> $employees,
                'tasks'      => $formatted,
                'tasks_meta' => [
                    'current_page' => $tasks->currentPage(),
                    'last_page'    => $tasks->lastPage(),
                    'total'        => $tasks->total(),
                    'per_page'     => $tasks->perPage(),
                ],
            ],
        ]);

    } catch (Exception $e) {
        return failedResponse($e->getMessage());
    }
}



public function addLinkHistory(Request $request)
{
    $request->validate([
        'post_gig_id' => 'required|exists:post_gigs,id',
    ]);

    $linkHistory = LinkHistory::create([
        'post_gig_id' => $request->post_gig_id,
    ]);

    return successResponse($linkHistory);
}

public function getAllPostGigs(Request $request)
{
    $perPage = $request->get('per_page', 15);

    $postGigs = PostGig::select('post_gigs.*')
        ->leftJoin(
            DB::raw('(SELECT post_gig_id, MAX(created_at) as last_linked_at FROM link_histories GROUP BY post_gig_id) as lh'),
            'post_gigs.id', '=', 'lh.post_gig_id'
        )
        ->orderByRaw('lh.last_linked_at IS NOT NULL ASC')  // never visited first
        ->orderBy('lh.last_linked_at', 'ASC')              // oldest visit next, recent last
        ->paginate($perPage);

    return successResponse($postGigs);
}


public function updateTaskTitleAndComments(Request $request, $id)
{
    $request->validate([
        'title'    => 'sometimes|string|max:255',
        'comments' => 'sometimes|nullable|string',
    ]);

    $task = Task::findOrFail($id);

    $payload = [];

    if ($request->has('title') && trim($request->title) !== '') {
        $payload['title'] = trim($request->title);
    }

    if ($request->has('comments')) {
        $payload['comments'] = $request->comments; // nullable, longText
    }

    if (empty($payload)) {
        return response()->json([
            'status'  => 422,
            'message' => 'No updatable fields provided.',
        ], 422);
    }

    $task->update($payload);

    return successResponse($task);
}


public function deletePhoneGig($id)
{
    $phoneGig = phoneGig::findOrFail($id);
    $phoneGig->callHistories()->delete(); // remove related call histories first
    $phoneGig->delete();
    return successResponse($phoneGig);
}

public function deletePostGig($id)
{
    $postGig = postGig::findOrFail($id);
    $postGig->linkHistories()->delete(); // remove related link histories first
    $postGig->delete();
    return successResponse($postGig);
}


    /**
     * GET /client/tasks
     * Returns the authenticated client's tasks, optionally scoped to a
     * single project via ?project_id=23, paginated via ?page=1.
     */

public function clientTasks(Request $request)
{
    $request->validate([
        'project_id' => 'nullable|integer|exists:projects,id',
        'status'     => 'nullable|string',
        'from'       => 'nullable|date',
        'to'         => 'nullable|date|after_or_equal:from',
        'page'       => 'nullable|integer|min:1',
        'per_page'   => 'nullable|integer|min:1|max:100',
    ]);

    $query = Task::query()
        ->with('files')
        ->where('project_id', $request->project_id)
        ->when($request->filled('status'), function ($q) use ($request) {
            $q->where('status', $request->status);
        })
        ->when($request->filled('from'), function ($q) use ($request) {
            $q->where('created_at', '>=', Carbon::parse($request->from)->startOfDay());
        })
        ->when($request->filled('to'), function ($q) use ($request) {
            $q->where('created_at', '<=', Carbon::parse($request->to)->endOfDay());
        });

    $tasks = $query
        ->orderBy('created_at', 'desc')
        ->paginate($request->input('per_page', 20));

    $tasks->getCollection()->transform(function ($task) {
        $task->images = $task->files->map(fn ($f) => \Storage::disk('public')->url($f->url));
        return $task;
    });

    return response()->json([
        'status'  => 200,
        'message' => 'success',
        'data'    => [
            'tasks'      => $tasks->items(),
            'tasks_meta' => [
                'current_page' => $tasks->currentPage(),
                'last_page'    => $tasks->lastPage(),
                'per_page'     => $tasks->perPage(),
                'total'        => $tasks->total(),
            ],
        ],
    ]);
}

    /**
     * POST /client/tasks/store
     * Creates multiple tasks under one project in a single request.
     *
     * Expected payload:
     * {
     *   "project_id": 23,
     *   "tasks": [
     *     { "title": "Write the release notes" },
     *     { "title": "Review PR #482" }
     *   ]
     * }
     */
public function clientTaskStore(Request $request)
{
    $validated = $request->validate([
        'project_id'       => 'required|integer|exists:projects,id',
        'tasks'            => 'required|array|min:1',
        'tasks.*.title'    => 'required|string|max:255',
        'tasks.*.images'   => 'nullable|array|max:6',
        'tasks.*.images.*' => 'nullable|image|max:5120', // 5MB
    ]);

    $ownsProject = Project::where('id', $validated['project_id'])->exists();

    if (! $ownsProject) {
        return response()->json([
            'status'  => 403,
            'message' => 'You do not have access to this project.',
        ], 403);
    }

    $destinationPath = public_path('uploads/tasks');

    if (! file_exists($destinationPath)) {
        mkdir($destinationPath, 0755, true);
    }

    $created = collect($validated['tasks'])->map(function ($task, $index) use ($validated, $request, $destinationPath) {

        $newTask = Task::create([
            'title'      => $task['title'],
            'project_id' => $validated['project_id'],
            'status'     => 0, // pending
            'date'       => now()->toDateString(),
            'isFixed'    => false,
        ]);

        $files = $request->file("tasks.$index.images", []);

        foreach ($files as $file) {
            if (! $file instanceof \Illuminate\Http\UploadedFile || ! $file->isValid()) {
                continue;
            }

            $fileName = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();

            $file->move($destinationPath, $fileName);

            $newTask->files()->create([
                'url' => 'uploads/tasks/' . $fileName,
            ]);
        }

        $newTask->load('files');

        $newTask->images = $newTask->files->map(function ($file) {
            return asset($file->url);
        });

        return $newTask;
    });

    return response()->json([
        'status'  => 201,
        'message' => 'success',
        'data'    => $created,
    ], 201);
}
}