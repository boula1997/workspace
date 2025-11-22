<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\TaskRequest;
use App\Http\Resources\ProjectResource;
use App\Http\Resources\NavigationResource;
use App\Http\Resources\IssueResource;
use App\Http\Resources\TaskResource;
use App\Models\Project;
use App\Models\Issue;
use App\Models\Query;
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
use App\Models\DBCredential;
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
        $clients = Admin::where("isActive", 1)->where("type", "client")->orderBy('name', 'ASC')->get();
        $prospectives = Admin::where("isActive", 1)->where("type", "prospective")->orderBy('name', 'ASC')->get();

        $projects = Project::orderBy("title", "asc")
            ->get();


        $allEmployees = Admin::where("type", "!=", "client")->where("type", "!=", "prospective")->orderBy('name', 'ASC')->get();
        $allClients = Admin::where("type", "client")->orderBy('name', 'ASC')->get();
        $projects = Project::orderBy("title", "asc")
            ->get();

        $naviagations = Navigation::orderBy('title', 'ASC')->get();
        $categories = Category::get();

        $projects = Project::orderBy("title", "asc")
            ->get();





        $queries = Query::latest("updated_at")->get();

        if (!isWithinWorkingHours()) {
            $tasksQuery = Task::where("status", 0)
                ->where("isOverthinking", 0)
                ->orderBy('project_id', 'asc')    // Then by project_id (ascending)
                ->latest('updated_at')            // Then by latest update
                // Limit to 300 tasks
                ;
            $issues = Issue::where("isOverthinking", 0)->orderBy("title", "asc")->get();

            $infoProjects = Project::where("isOverthinking", 0)->orderBy("title", "asc")->get(); // ✅ sort

        } else {
            $tasksQuery = Task::where("status", 0)
                ->orderBy('project_id', 'asc')    // Then by project_id (ascending)
                ->latest('updated_at')            // Then by latest update
                // Limit to 300 tasks
                ;
            $infoProjects = Project::orderBy("title", "asc")
                ->get();
            $issues = Issue::orderBy("title", "asc")->get();
        }

            // Apply search filter if present
if ($request->has('search') && $request->search != '') {
    $search = $request->search;

    $tasksQuery->where(function($q) use ($search) {
        // Search by title
        $q->where('title', 'like', "%$search%");

        // Search by project title
        $q->orWhereHas('project', function($qp) use ($search) {
            $qp->where('title', 'like', "%$search%");
        });

        // Search by employees JSON column
        $q->orWhere(function($qe) use ($search) {
            $qe->whereRaw("EXISTS (
                SELECT 1
                FROM admins
                WHERE JSON_CONTAINS(tasks.employees, CAST(admins.id AS JSON))
                AND admins.name LIKE ?
            )", ["%$search%"]);
        });
    });
}

    // Paginate tasks 
    $tasks = $tasksQuery->paginate(20);

        $credentials = DBCredential::get();
        $tablePprojects = Project::where("status", "!=", 0)->orWhere("deal", 0)->orderBy("title", "asc")->get();
        if (boula())
            $data = [
                "queries" => $queries,
                "projects" => ProjectResource::collection($projects),
                "infoProjects" => ProjectResource::collection($infoProjects),
                "boardProjects" => ProjectResource::collection(
                    Project::orderBy("deadline", "asc")
                        ->get()
                        ->filter(fn($project) => $project->status == 1)
                ),
                "tablePprojects" => ProjectResource::collection($tablePprojects),
                "refrences" => IssueResource::collection($issues),
                "employees" => $employees,
                "clients" => $clients,
                "prospectives" => $prospectives,
                "credentials" => $credentials,
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
                "infoProjects" => ProjectResource::collection($infoProjects),
                "boardProjects" => ProjectResource::collection(
                    Project::orderBy("deadline", "asc")
                        ->get()
                        ->filter(fn($project) => $project->status == 1)
                ),
                "credentials" => $credentials,
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
                "tablePprojects" => ProjectResource::collection($tablePprojects),

            ];

        return successResponse($data);
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





public function createFinished(Request $request)
{
    $employees = Admin::where("isActive", 1)
        ->where("type", "!=", "client")
        ->select('admins.*')
        ->selectRaw("
            (
                SELECT COUNT(*)
                FROM tasks
                WHERE tasks.status = 1
                AND JSON_CONTAINS(tasks.employees, JSON_QUOTE(CAST(admins.id AS CHAR)))
            ) as pending_tasks_count
        ")
        ->orderBy('name', 'ASC')
        ->get();

    $clients = Admin::where("isActive", 1)
        ->where("type", "client")
        ->orderBy('name', 'ASC')
        ->get();

    $projects = Project::orderBy("title", "asc")->get();

    // Base query for tasks
    if (!isWithinWorkingHours()) {
        $tasksQuery = Task::where("status", 1)
            ->where("isOverthinking", 0)
            ->latest('updated_at');
    } else {
        $tasksQuery = Task::where("status", 1)
            ->latest('updated_at');
    }

    // Apply search filter if present
if ($request->has('search') && $request->search != '') {
    $search = $request->search;

    $tasksQuery->where(function($q) use ($search) {
        // Search by title
        $q->where('title', 'like', "%$search%");

        // Search by project title
        $q->orWhereHas('project', function($qp) use ($search) {
            $qp->where('title', 'like', "%$search%");
        });

        // Search by employees JSON column
        $q->orWhere(function($qe) use ($search) {
            $qe->whereRaw("EXISTS (
                SELECT 1
                FROM admins
                WHERE JSON_CONTAINS(tasks.employees, CAST(admins.id AS JSON))
                AND admins.name LIKE ?
            )", ["%$search%"]);
        });
    });
}


    // Paginate tasks 
    $tasks = $tasksQuery->paginate(20);

    $data = [
        "projects" => ProjectResource::collection($projects),
        "employees" => $employees,
        "clients" => $clients,
        "tasks" => TaskResource::collection($tasks),
        "tasks_meta" => [
            "current_page" => $tasks->currentPage(),
            "last_page" => $tasks->lastPage(),
            "per_page" => $tasks->perPage(),
            "total" => $tasks->total(),
        ],
        "last_time" => setting()->last_time . ' ' . getTimeAgo(setting()->last_time),
        "allowedIn" => date('Y-m-d', strtotime(setting()->last_time . ' + 3 days')),
        "deadlineAction" => activeDeadline()["action"],
        "deadlineDate" => activeDeadline()["deadline"],
        "isExpired" => isExpired()[0],
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
                $data['title'] = $request->name;
                $data['cost'] = (int) $request->cost;
                $data['githubDevModeLinkFront'] = $request->githubDevModeLinkFront;
                $data['githubDevModeLinkBack'] = $request->githubDevModeLinkBack;
                $data['deadline'] = $request->deadline;
                $data['renewalDate'] = $request->renewalDate;
                $data['deal'] = $request->deal ? 1 : 0;
                $data['isHosted'] = $request->isHosted ? 1 : 0;
                $data['isOverthinking'] = $request->isOverthinking ? 1 : 0;
                $data['isYousab'] = $request->isYousab ? 1 : 0;
                $data['fixed'] = $request->fixed ? 1 : 0;
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
            $task->update(['piority' => !$task->piority]);
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

            // Find and toggle the level for the given task ID
            $task = Task::find($id);
            $task->update(['status' => !$task->status]);

            $task = Task::find($id);

            return successResponse($task);
            return response()->json(['success' => __('general.deleted_successfully')]);
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
    public function piorityTasks()
    {
        try {

            $tasks = Task::where("status", 0)->where("piority", 1)->latest()->get();
            $data["tasks"] = TaskResource::collection($tasks);
            $data["isExpired"] = isExpired()[0];
            return successResponse($data);
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()]);
        }
    }




        public function elements($id, Request $request)
        {
            try {

                $search   = $request->query('search');
                $perPage  = $request->query('per_page', 10);

                // Remove global scopes for Category
                $category = Category::withoutGlobalScopes()->find($id);

                if (!$category) {
                    return response()->json(['error' => 'Category not found'], 404);
                }

                // Helper to apply search on title
                $applySearch = function ($query, $column = 'title') use ($search) {
                    if ($search) {
                        $query->where($column, 'like', "%{$search}%");
                    }
                };

                switch ($category->title) {

                    case "projects":
                        $query = Project::latest()->withoutGlobalScopes();
                        $applySearch($query, 'title');
                        $items = $query->paginate($perPage);

                        break;

                    case "notes":
                        if (!boula()) break;

                        $query = Note::latest()->withoutGlobalScopes()->where("isOverthinking", 0);
                        $applySearch($query, 'title');
                        $items = $query->paginate($perPage);

                        break;

                        case "admins":
                            $query = Admin::latest()->withoutGlobalScopes()->orderBy('name', 'ASC');
                            $applySearch($query, 'name');
                            $items = $query->paginate($perPage);

                            // تحويل الـ paginator عشان يضيف title
                            $items->getCollection()->transform(function ($item) {
                                return [
                                    'id'    => $item->id,
                                    'title' => $item->name, // ⬅ عنوان الـ admin
                                    'link'  => url("module/admins/edit/{$item->id}"),
                                    'type'  => 'admin',
                                ];
                            });

                            break;


                    case "navigations":
                        $query = Navigation::latest()->withoutGlobalScopes()->orderBy('title', 'ASC');
                        $applySearch($query, 'title');
                        $items = $query->paginate($perPage);

                        break;

                        case "categories":
                            $query = Category::latest()->withoutGlobalScopes();

                            if ($search) {
                                $query->whereTranslationLike('title', "%{$search}%");
                            }

                            $items = $query->paginate($perPage);

                            break;


                            case "roles":
                                if (!boula()) break;

                                $query = Role::latest()->withoutGlobalScopes();
                                $applySearch($query, 'name');
                                $items = $query->paginate($perPage);

                                // تحويل الـ paginator عشان يضيف title
                                $items->getCollection()->transform(function ($item) {
                                    return [
                                        'id'    => $item->id,
                                        'title' => $item->name, // ⬅ هنا عنوان الـ role
                                        'link'  => url("module/roles/edit/{$item->id}"),
                                        'type'  => 'role',
                                    ];
                                });

                                break;


                        case "d_b_credentials":
                            $query = DBCredential::latest()->withoutGlobalScopes();
                            $applySearch($query, 'db_name');
                            $items = $query->paginate($perPage);

                            // ✨ هنا التحويل
                            $items->getCollection()->transform(function ($item) {
                                return [
                                    'id'        => $item->id,
                                    'title'     => $item->db_name, // ⬅ عنوان الـ item
                                    'username'  => $item->db_username,
                                    'host'      => $item->db_host,
                                    'isActive'  => $item->isActive,
                                    'link'      => url("module/d_b_credentials/edit/{$item->id}"),
                                    'type'      => 'd_b_credentials',
                                ];
                            });

                            break;


                    case "issues":
                        if (!boula()) break;

                        $query = Issue::latest()->withoutGlobalScopes();
                        $applySearch($query, 'title');
                        $items = $query->paginate($perPage);

                        break;

                    case "portfolios":
                        $query = Gallery::latest()->withoutGlobalScopes();
                        $applySearch($query, 'title');
                        $items = $query->paginate($perPage);

                        break;

                    case "videos":
                        $query = Video::latest()->withoutGlobalScopes();
                        $applySearch($query, 'title');
                        $items = $query->paginate($perPage);

                        break;
                    case "deadlines":
                        $query = Deadline::where("status",1)->latest()->withoutGlobalScopes();
                        $applySearch($query, 'title');
                        $items = $query->paginate($perPage);

                        break;

                        case "fees":
                            $query = Fee::withoutGlobalScopes()->latest();
                            $applySearch($query, 'amount');
                            $items = $query->paginate($perPage);

                            // إضافة title لكل عنصر
                            $items->getCollection()->transform(function ($item) {
                                return [
                                    'id'    => $item->id,
                                    'title' => $item->amount . " EGP", // ⬅ عنوان الـ fee
                                    'link'  => url("module/fees/edit/{$item->id}"),
                                    'type'  => 'fee',
                                ];
                            });

                            break;


                        case "tasks":

                            $search = $request->query('search');
                            $perPage = $request->query('per_page', 20);

                            $query = Task::latest()->where("status",1)->with('project') // load project title
                                        ->withoutGlobalScopes();

                            // 🔍 Apply search on both task title + project title
                            if ($search) {
                                $query->where(function($q) use ($search) {
                                    $q->where('title', 'LIKE', "%{$search}%") // task title
                                    ->orWhereHas('project', function($p) use ($search) {
                                        $p->where('title', 'LIKE', "%{$search}%"); // project title
                                    });
                                });
                            }

                            $items = $query->paginate($perPage);


                            break;


                    default:
                        return response()->json(['error' => 'Unsupported category'], 400);
                }

                return successResponse([
                    "elements"   => $items,     // full pagination object
                    "isExpired"  => isExpired()[0],
                ]);

            } catch (Exception $e) {
                return response()->json(['error' => $e->getMessage()]);
            }
        }


    public function deadlines()
    {
        try {

            $deadlines = Deadline::latest()->orderBy("date", "asc")->get();
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
            if ($request->action == "delete")
                $deadline->update(["status" => !$deadline->status]);
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

    public function lifIssue()
    {

        try {
            if (boula()) {

                $lifeIssue = Issue::where("id", 66)->first();


                return response()->json([
                    'message' => 'User is Boula',
                    'data' => $lifeIssue
                ], 201);
            }
        } catch (Ecxception $e) {
            dd($e->getMessage());
        }
    }


}
