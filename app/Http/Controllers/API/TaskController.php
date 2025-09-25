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
use App\Models\Navigation;
use App\Models\Task;
use App\Models\DBCredential;
use Exception;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;


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


    public function create()
    {
        $employees = Admin::where("isActive",1)
            ->where("type","!=","client")
            ->withCount(['tasks as active_tasks_count' => function ($query) {
                $query->where('status', 0);   // 👈 only count tasks with status=0
            }])
            ->orderBy('name', 'ASC')
            ->get();
        $clients = Admin::where("isActive",1)->where("type","client")->orderBy('name', 'ASC')->get();
                        $projects = Project::orderBy("title","asc")
                    ->get(); 

        $allEmployees = Admin::where("type","!=","client")->orderBy('name', 'ASC')->get();
        $allClients = Admin::where("type","client")->orderBy('name', 'ASC')->get();
                        $projects = Project::orderBy("title","asc")
                    ->get(); 

        $naviagations = Navigation::orderBy('title', 'ASC')->get();
        $categories = Category::get();

        $projects = Project::orderBy("title","asc")
                    ->get(); 


           
           
           
           $queries=Query::latest()->get();
        
            if(!isWithinWorkingHours()){
                        $tasks = Task::where("status", 0)
            ->where("isOverthinking",0)
            ->orderBy('project_id', 'asc')    // Then by project_id (ascending)
            ->latest('updated_at')            // Then by latest update
            ->take(300)                       // Limit to 300 tasks
            ->get()
            ->unique('title');     
                $issues = Issue::where("isOverthinking",0)->orderBy("title","asc")->get();

                $infoProjects = Project::where("isOverthinking",0)->orderBy("title","asc")->get(); // ✅ sort

            }else{
          $tasks = Task::where("status", 0)
            ->orderBy('project_id', 'asc')    // Then by project_id (ascending)
            ->latest('updated_at')            // Then by latest update
            ->take(300)                       // Limit to 300 tasks
            ->get()
            ->unique('title');     
                $infoProjects = Project::orderBy("title","asc")
                    ->get();
                $issues = Issue::orderBy("title","asc")->get();
            }

            $credentials = DBCredential::get();
            $tablePprojects = Project::where("status","!=",0)->orWhere("deal",0)->orderBy("title","asc")->get();
        if(boula())
        $data=[
            "queries"=>$queries,
            "projects"=>ProjectResource::collection($projects),
            "infoProjects"=>ProjectResource::collection($infoProjects),
            "boardProjects" => ProjectResource::collection(
                Project::orderBy("deadline","asc")
                    ->get()
                    ->filter(fn($project) => $project->status == 1) 
            ),
            "tablePprojects"=>ProjectResource::collection($tablePprojects),
            "refrences"=>IssueResource::collection($issues),
            "employees"=>$employees,
            "clients"=>$clients,
            "credentials"=>$credentials,
            "tasks"=>TaskResource::collection($tasks),
            "last_time" => setting()->last_time . ' ' . getTimeAgo(setting()->last_time),
            "isExpired" => isExpired()[0],
            "headings"=>[
                "allowedIn"=>date('Y-m-d', strtotime(setting()->last_time . ' + 3 days')),
                "deadlineAction"=>activeDeadline()["action"],
                "deadlineDate"=>activeDeadline()["deadline"],
            ]

        ];
        
        else
        $data=[
            "projects"=>ProjectResource::collection($projects),
            "infoProjects"=>ProjectResource::collection($infoProjects),
            "boardProjects" => ProjectResource::collection(
                Project::orderBy("deadline","asc")
                    ->get()
                    ->filter(fn($project) => $project->status == 1) 
            ),
            "credentials"=>$credentials,
            "employees"=>$employees,
            "clients"=>$clients,
            "tasks"=>TaskResource::collection($tasks),
            "last_time" => setting()->last_time . ' ' . getTimeAgo(setting()->last_time),
            "tablePprojects"=>ProjectResource::collection($tablePprojects),

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

            $yearTotalIncome=0;
            $yearTotalOutcome=0;
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

                      $monthlyProjects = Project::whereBetween('created_at', [$startOfCurrentMonth, $endOfCurrentMonth])->where("cost",">",0)->count();
                      $allProjects = Project::where("cost",">",0)->count();
                     

                $monthlyIncomeArray[] = $monthlyIncome; // You can round() if needed
                $yearTotalIncome+= $monthlyIncome; // You can round() if needed
                $monthlyOutcomeArray[] = $monthlyOutcome*-1; // You can round() if needed
                $yearTotalOutcome+= $monthlyOutcome*-1; // You can round() if needed
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
                return rest($project) > 0 || ($project->status == 2 && $project->cost!=0);
            })->sortByDesc(fn($project) => rest($project));

            $dueMoneyProjects = $projects->filter(function ($project) {
                return rest($project) > 0 && $project->status == 2 ;
            })->sortByDesc(fn($project) => rest($project));

            // Total of rest
            $totalRest = $selectedProjects->sum(fn($project) => rest($project));

            $totalDueRest = $dueMoneyProjects->sum(fn($project) => rest($project));
            $totalFutureRest = $totalRest- $totalDueRest;

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

            // Prepare response data
            $data = [
                "projects" => ProjectResource::collection($selectedProjects),
                "boardProjects" => ProjectResource::collection(
                    Project::latest()->get()->sortByDesc(fn($project) => rest($project))
                ),
                "conMoneyProjects" => ProjectResource::collection(
                    Project::get()
                    ->filter(fn($project) => $project->status == 2 || $project->deal==0)->sortByDesc(fn($project) => $project->status)
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
                "alloutcomeFees" => $alloutcomeFees*-1,
                "allincomeFees" => $allincomeFees,
                "yearTotalIncome" => $yearTotalIncome,
                "yearTotalOutcome" => $yearTotalOutcome,
                "monthlyIncomeArray" => $monthlyIncomeArray,
                "monthlyOutcomeArray" => $monthlyOutcomeArray,
                "monthlyProjectsArray" => $monthlyProjectsArray,
                "moneyProjectIds" => $moneyProjectIds,
                "allProjects" => $allProjects,
                "pieCostProjects" =>ProjectResource::collection(Project::where("cost",">",0)->orderBy("cost","desc")->take(15)->get()),
                "last_time" => setting()->last_time . ' ' . getTimeAgo(setting()->last_time),
                "allowedIn"=>date('Y-m-d', strtotime(setting()->last_time . ' + 3 days')),
                "deadlineAction"=>activeDeadline()["action"],
                "deadlineDate"=>activeDeadline()["deadline"],
                "totalRest"=>$totalRest,
                "totalGained"=>$totalCost-$totalRest,
                "totalDueRest"=>$totalDueRest,
                "totalFutureRest"=>$totalFutureRest,
                "target"=>settings()->target,
                "contractProjects"=>count($contractProjects),
                "moneyProjectsListCount">count($moneyProjectsList),
                "contracts"=>$contractProjects,
                "moneyProjects"=>count($moneyProjects),
                "progressProjects"=>count($progressProjects),
                "finishedProjects"=>count($finishedProjects),
                "isExpired" => isExpired()[0],

            ];


            return successResponse($data);
        }





    public function createFinished()
    {
        

        $employees = Admin::where("isActive",1)
            ->where("type","!=","client")
            ->withCount(['tasks as finished_tasks_count' => function ($query) {
                $query->where('status', 1);   // 👈 only count tasks with status=1
            }])
            ->orderBy('name', 'ASC')
            ->get();

            
        $clients = Admin::where("isActive",1)->where("type","client")->orderBy('name', 'ASC')->get();


                $projects = Project::orderBy("title","asc")
                    ->get(); 



            if(!isWithinWorkingHours())
            $tasks = Task::where("status", 1)
            ->where("isOverthinking",0)
            ->latest('updated_at') // Then by latest updated time
            ->take(300)            // Limit to 300 tasks
            ->get()
            ->unique('title');     // Remove duplicate tasks by title
        else
            $tasks = Task::where("status", 1)
            ->whereHas('project', function ($query) {
                $query->where('status', '!=', 1);
            })
            ->latest('updated_at') // Then by latest updated time
            ->take(300)            // Limit to 300 tasks
            ->get()
            ->unique('title');  

        $data=[
            "projects"=>ProjectResource::collection($projects),
            "employees"=>$employees,
            "clients"=>$clients,
            "tasks"=>TaskResource::collection($tasks),
                "last_time" => setting()->last_time . ' ' . getTimeAgo(setting()->last_time),
                "allowedIn"=>date('Y-m-d', strtotime(setting()->last_time . ' + 3 days')),
                "deadlineAction"=>activeDeadline()["action"],
                "deadlineDate"=>activeDeadline()["deadline"],
            "isExpired" => isExpired()[0],


        ];

        return successResponse($data);
    }


    public function store(TaskRequest $request)
    {
        try {
        


            $overthinkingTasks=Task::where("isOverthinking",1)->get();
            $tasks=Task::get();

            if(count($tasks)==count($overthinkingTasks) && !isWithinWorkingHours())
              return failedResponse([]);

            $titles = explode('+', $request->title);
            foreach ($titles as $title) {
                foreach ($request->employees as $employee) {
                    Task::create([
                        'title' => $title,
                        'employee_id' => $employee,
                        'project_id' => $request->project_id,
                        'piority' => $request->piority,

                    ]);
                }
            }


            $data=[];

            return successResponse($data);


        } catch (Exception $e) {
            dd($e->getMessage());
            return redirect()->back()->with(['error' => __('general.something_wrong')]);
        }
    }
    public function refproPost(Request $request)
    {
        try {
                if(!isWithinWorkingHours()){
                    return failedResponse([]);
                }

                  if(isset($request->project_id)){
                      $result=Project::find($request->project_id);
                      $data['codeLinks']=$request->title;
                      $data['title']=$request->name;
                      $data['cost'] = (int) $request->cost; 
                      $data['githubDevModeLinkFront'] = $request->githubDevModeLinkFront; 
                      $data['githubDevModeLinkBack'] = $request->githubDevModeLinkBack; 
                      $data['deadline'] = $request->deadline; 
                      $data['renewalDate'] = $request->renewalDate; 
                      $data['deal'] = $request->deal?1:0; 
                      $data['isHosted'] = $request->isHosted?1:0; 
                      $data['isOverthinking'] = $request->isOverthinking?1:0; 
                      $data['isYousab'] = $request->isYousab?1:0; 
                      $data['fixed'] = $request->fixed?1:0; 
                      $result->update($data);
                  }
                   else if(isset($request->refrence_id)){
                       $result=Issue::find($request->refrence_id);
                       $result->update(["codeLinks" => $request->title]);
                   }

                   $data=["result"=>$result->codeLinks,"project"=>$result];
       
                   return successResponse($data);


        } catch (Exception $e) {
            DB::table('tracks')->insert([ 'dispatch_status' => 'showing data of ' . json_encode($e->getMessage()), 'created_at' => now(), ]);
            dd($e->getMessage());
            return redirect()->back()->with(['error' => __('general.something_wrong')]);
        }
    }


    public function refproGet(Request $request)
    {
        try {
          if(!isWithinWorkingHours()){
              return failedResponse([]);
          }
       
                  if(isset($request->project_id)){
                      $result=Project::find($request->project_id);
                  }
                   else if(isset($request->refrence_id)){
                       $result=Issue::find($request->refrence_id);
                   }
       
                   $data=["result"=>$result->codeLinks,"project"=>$result];
       
                   return successResponse($data);

        } catch (Exception $e) {
            DB::table('tracks')->insert([ 'dispatch_status' => 'showing data of ' . json_encode($e->getMessage()), 'created_at' => now(), ]);
            dd($e->getMessage());
            return redirect()->back()->with(['error' => __('general.something_wrong')]);
        }
    }

        public function togglePiority($id)
    {
        try {

     if(!isWithinWorkingHours())
      return failedResponse([]);

        // Find and toggle the level for the given task ID
        $task = Task::find($id);
        $task->where('title', $task->title)->update(['piority' => !$task->piority]);
        return response()->json(['success' => __('general.changed_successfully'.$task->piority)]);
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()]);
        }
    }
        public function toggleStatus($id)
    {
        try {

             if(!isWithinWorkingHours())
              return failedResponse([]);

                 // Find and toggle the level for the given task ID
                 $task = Task::find($id);
                 $task->where('title', $task->title)->update(['status' => !$task->status]);
     
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
           
            if(boula())
             $links = Navigation::where("category_id",$id)->orderBy('title', 'asc')->get();
            else
             $links=[];
             $data["links"]=NavigationResource::collection($links);
             $data["isExpired"]=isExpired()[0];
             return successResponse($data);

        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()]);
        }
    }


        public function elements($id)
    {
        try {
            $elements=[];
             $category=Category::find($id);
             if($category->title=="products"){
                $projects=Project::get();
                foreach ($projects as $project) {
                    $elements[] = [
                    'title' => $project->title,  
                    'link'  => "https://yousab-tech.com/workspace/public/en/dashboard/projects/".$project->id."/edit",
                        'type'  => "project",
                    ];
                }
             }else if($category->title=="notes"){
                $notes=Note::get();
                foreach ($notes as $note) {
                    $elements[] = [
                    'title' => $note->title,  
                    'link'  => "https://yousab-tech.com/workspace/public/en/dashboard/notes/".$note->id."/edit",
                        'type'  => "note",
                    ];
                }
             }else if($category->title=="admins"){
                $admins = Admin::orderBy('name', 'ASC')->get();
                foreach ($admins as $admin) {
                    $elements[] = [
                        'title' => $admin->name,  
                        'link'  => "https://yousab-tech.com/workspace/public/en/dashboard/admins/".$admin->id."/edit",
                        'type'  => "admin",
                    ];
                }
             }else if($category->title=="navigations"){
                $navigations = Navigation::orderBy('name', 'ASC')->get();
                foreach ($navigations as $navigation) {
                    $elements[] = [
                        'title' => $navigation->name,  
                        'link'  => "https://yousab-tech.com/workspace/public/en/dashboard/navigations/".$navigation->id."/edit",
                        'type'  => "navigation",
                    ];
                }
             }else if($category->title=="categories"){
                $categories = Category::orderBy('name', 'ASC')->get();
                foreach ($categories as $category) {
                    $elements[] = [
                        'title' => $category->name,  
                        'link'  => "https://yousab-tech.com/workspace/public/en/dashboard/categories/".$category->id."/edit",
                        'type'  => "category",
                    ];
                }
             }

             $data["elements"]=$elements;
             $data["isExpired"]=isExpired()[0];
             return successResponse($data);

        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()]);
        }
    }

        public function deadlines()
    {
        try {
           
            $deadlines=Deadline::orderBy("date","asc")->get();
            $data["deadlines"]=$deadlines;
            $data["isExpired"]=isExpired()[0];
            if(boula())
             return successResponse($data);
             else
             return successResponse([]);

        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()]);
        }
    }


        public function updateDeadline(Request $request)
        {
            try {
                $deadline=Deadline::find($request->id);
                if($request->action=="delete")
                    $deadline->update(["status"=>!$deadline->status]);
                else if(isset($request->date))
                    $deadline->update(["date"=>$request->date]);

                $deadlines=Deadline::orderBy("date","asc")->get();


                $data=["boardProjects"=>$deadlines,"action"=>$request->action];

                return successResponse($data);


            } catch (Exception $e) {
                DB::table('tracks')->insert([ 'dispatch_status' => 'showing data of ' . json_encode($e->getMessage()), 'created_at' => now(), ]);
                return failedResponse($e->getMessage());
            }
        }

        public function updateProjectDeadline(Request $request)
        {
            try {

                DB::table('tracks')->insert([ 'dispatch_status' => 'showing data of ' . json_encode($request->all()), 'created_at' => now(), ]);
                $deadline=Project::find($request->id);

               $deadlineTime = Carbon::parse($request->date, 'UTC')->setTimezone('Africa/Cairo');
               $deadline->update(["deadline" => $deadlineTime]);

                $deadlines=Project::orderBy("deadline","asc")->get();


                $data=[            "boardProjects" => ProjectResource::collection(
                Project::orderBy("deadline","asc")
                    ->get()
                    ->filter(fn($project) => $project->status != 1) 
            )];

                return successResponse($data);


            } catch (Exception $e) {
                DB::table('tracks')->insert([ 'dispatch_status' => 'showing data of ' . json_encode($e->getMessage()), 'created_at' => now(), ]);
                return failedResponse($e->getMessage());
            }
        }




        public function storeDeadline(Request $request)
    {
        try {
             if(boula())
            $deadline=Deadline::create(["title"=>$request->title,"date"=>$request->date]);

            $deadlines=Deadline::orderBy("date","asc")->get();


            $data=["deadlines"=>$deadlines,"action"=>$request->action];

            return successResponse($data);


        } catch (Exception $e) {
            return failedResponse($e->getMessage());
        }
    }



public function execQuery(Request $request)
{
    
    DB::beginTransaction(); // Start transaction

    try {
        $credential = DBCredential::where('id', $request->credential_id)->first();
        $dbHost = isset($credential->db_host)?$credential->db_host:'192.185.41.219';
        $dbName = $credential->db_name ?? 'automation';
        $dbUser = $credential->db_username ?? 'root';
        $dbPass = $credential->db_password ?? '';

        config([
            'database.connections.dynamic' => [
                'driver' => 'mysql',
                'host' => $dbHost,
                'database' => $dbName,
                'username' => $dbUser,
                'password' => $dbPass,
                'charset' => 'utf8mb4',
                'collation' => 'utf8mb4_unicode_ci',
            ],
        ]);

        DB::purge('dynamic');
        DB::reconnect('dynamic');

        $queryCommands = explode('++', $request->title);
        $finalResult = [];

            $query = Query::firstOrCreate(['title' => $request->title]);


        foreach ($queryCommands as $queryCommand) {
              // Normalize query: remove extra whitespace and lowercase for case-insensitive matching
            $normalizedQuery = preg_replace('/\s+/', ' ', strtolower(trim($queryCommand, "; \t\n\r\0\x0B")));

                if (str_starts_with($normalizedQuery, 'update') && strpos($normalizedQuery, 'where') === false) {
                         return response()->json([
                        'success' => "Done Successfully",
                        'data' => "Add condition",
        ]);
                }
        }

        foreach ($queryCommands as $queryCommand) {



            DB::connection('dynamic')->statement('use ' . $credential->db_name);
            $data = DB::connection('dynamic')->select($queryCommand);

            $cleanedData = array_map(function ($row) {
                $row = (array) $row; // Ensure it's an array, not stdClass
                if (isset($row['codeLinks'])) {
                    $row['codeLinks'] = preg_replace('/\s+/', ' ', $row['codeLinks']);
                    $row['codeLinks'] = trim($row['codeLinks']);
                }
                if (isset($row['script'])) {
                $row['script'] = preg_replace('/\s+/', ' ', $row['script']);
                $row['script'] = trim($row['script']);
                }
                if (isset($row['dispatch_status'])) {
                $row['dispatch_status'] = preg_replace('/\s+/', ' ', $row['dispatch_status']);
                $row['dispatch_status'] = trim($row['dispatch_status']);
                }
                return $row;
            }, $data);

            $finalResult[] = [
                'query' => $queryCommand,
                'result' => $cleanedData,
            ];

        }

        DB::commit(); // Commit transaction if everything is fine

        return response()->json([
            'success' => "Done Successfully",
            'data' => $finalResult,
        ]);

    } catch (\Exception $e) {
        DB::rollBack(); // Rollback if something goes wrong


        return response()->json([
            'success' => false,
            'error' => $e->getMessage(),
            'data' => $e->getMessage(),
        ]);
    }
}


    public function track(Request $request) {

        try{

            $data=[];

            DB::table('tracks')->insert([ 'dispatch_status' => 'showing data of ' . json_encode(request()->all()), 'created_at' => now(),'updated_at' => now(), ]);
            
            return response()->json([
                'message' => 'User successfully registered',
                'user' => $data
            ], 201);
        }catch(Ecxception $e){
            dd($e->getMessage());
        }
    }

    public function lifIssue() {

        try{
     if(boula()){

         $lifeIssue=Issue::where("id",66)->first();
                 
                 
                 return response()->json([
                     'message' => 'User is Boula',
                     'data' => $lifeIssue
                 ], 201);
     }
        }catch(Ecxception $e){
            dd($e->getMessage());
        }
    }



}
