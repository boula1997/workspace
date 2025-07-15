<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\TaskRequest;
use App\Http\Resources\ProjectResource;
use App\Http\Resources\IssueResource;
use App\Http\Resources\TaskResource;
use App\Models\Project;
use App\Models\Issue;
use App\Models\Fee;
use App\Models\Admin;
use App\Models\Deadline;
use App\Models\Navigation;
use App\Models\Task;
use Exception;
use Illuminate\Http\Request;
use Carbon\Carbon;

class TaskController extends Controller
{
    private $task;
    public function __construct(Task $task)
    {
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
        $employees = Admin::orderBy('name', 'ASC')->get();
        
            if(!isWithinWorkingHours()){
                $tasks=[];
                $issues = Issue::where("isOverthinking",0)->orderBy("title","asc")->get();
                $projects = Project::where("isOverthinking",0)->where("status","!=",0)->orWhere("deal",0)->orderBy("title","asc")->get();

            }else{
                $tasks = Task::where("status", 0)
                ->orderBy('piority', 'desc') // Then by priority (descending)
                ->orderBy('project_id', 'asc') // Order by project first
                ->latest('updated_at') // Then by creation date (latest first)
                ->take(300) // Limit to 300 tasks
                ->get()
                ->unique('title'); // Remove duplicate tasks by title
                $projects = Project::where("status","!=",0)->orWhere("deal",0)->orderBy("title","asc")->get();
                $issues = Issue::orderBy("title","asc")->get();
            }
        if(boula())
        $data=[
            "projects"=>ProjectResource::collection($projects),
            "refrences"=>IssueResource::collection($issues),
            "employees"=>$employees,
            "tasks"=>TaskResource::collection($tasks),
            "last_time" => setting()->last_time . ' ' . getTimeAgo(setting()->last_time),
            "headings"=>[
                "allowedIn"=>date('Y-m-d', strtotime(setting()->last_time . ' + 3 days')),
                "deadlineAction"=>activeDeadline()["action"],
                "deadlineDate"=>activeDeadline()["deadline"],
            ]

        ];
        
        else
        $data=[
            "projects"=>ProjectResource::collection($projects),
            // "refrences"=>IssueResource::collection($issues),
            "employees"=>$employees,
            "tasks"=>TaskResource::collection($tasks),
            "last_time" => setting()->last_time . ' ' . getTimeAgo(setting()->last_time),
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
            $projects = Project::where('title', 'NOT LIKE', '%aloo%')->latest()->get();
$selectedProjects = $projects->filter(fn($project) => rest($project) > 0)
                              ->sortByDesc(fn($project) => rest($project));

// Total of rest
$totalRest = $selectedProjects->sum(fn($project) => rest($project));

// Total of project cost
$totalCost = $selectedProjects->sum('cost');

            // Prepare response data
            $data = [
                "projects" => ProjectResource::collection($selectedProjects),
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
                "allProjects" => $allProjects,
                "last_time" => setting()->last_time . ' ' . getTimeAgo(setting()->last_time),
                "allowedIn"=>date('Y-m-d', strtotime(setting()->last_time . ' + 3 days')),
                "deadlineAction"=>activeDeadline()["action"],
                "deadlineDate"=>activeDeadline()["deadline"],
                "totalRest"=>$totalRest,
                "totalGained"=>$totalCost-$totalRest,
                "target"=>setting()->target,
            ];


            return successResponse($data);
        }





    public function createFinished()
    {
        $employees = Admin::orderBy('name', 'ASC')->get();
        $projects = Project::where('title', 'NOT LIKE', '%aloo%')->where("status","!=",0)->orWhere("deal",0)->orderBy("title","asc")->get();

        $tasks = Task::where("status", 1)
            ->latest('updated_at') // Then by creation date (latest first)
            ->take(300) // Limit to 300 tasks
            ->get()
            ->unique('title'); // Remove duplicate tasks by title
            if(!isWithinWorkingHours())
            $tasks=[];
        $data=[
            "projects"=>ProjectResource::collection($projects),
            "employees"=>$employees,
            "tasks"=>TaskResource::collection($tasks),
                "last_time" => setting()->last_time . ' ' . getTimeAgo(setting()->last_time),
                "allowedIn"=>date('Y-m-d', strtotime(setting()->last_time . ' + 3 days')),
                "deadlineAction"=>activeDeadline()["action"],
                "deadlineDate"=>activeDeadline()["deadline"],

        ];

        return successResponse($data);
    }


    public function store(TaskRequest $request)
    {
        try {


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
    public function refpro(Request $request)
    {
        try {


                $update=false;
                $action=false;
       
                  if(isset($request->project_id)){
                       $update=$request->project_id==setting()->reqValue && setting()->reqType=="project";
                      $result=Project::find($request->project_id);
                      setting()->update(["reqType"=>"project","reqValue"=>$request->project_id]);
                  }
                   else if(isset($request->refrence_id)){
                       $update=$request->refrence_id==setting()->reqValue && setting()->reqType=="refrence";
                       $result=Issue::find($request->refrence_id);
                      setting()->update(["reqType"=>"refrence","reqValue"=>$request->refrence_id]);
       
                   }
         
                   if ($result && $update && trim($request->title) !== '') {
       
                       $result->update(["codeLinks" => $request->title]);
                       $action=true;
                   }
       
       
                   $data=["result"=>$result->codeLinks,"action"=>$action];
       
                   return successResponse($data);


        } catch (Exception $e) {
            dd($e->getMessage());
            return redirect()->back()->with(['error' => __('general.something_wrong')]);
        }
    }

        public function togglePiority($id)
    {
        try {

                // Find and toggle the level for the given task ID
                $task = Task::find($id);
                $task->where('title', $task->title)->update(['piority' => !$task->piority]);
    
    
    
                return response()->json(['success' => __('general.changed_successfully')]);
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()]);
        }
    }
        public function toggleStatus($id)
    {
        try {

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

        public function links()
    {
        try {
           
            if(boula())
             $links=Navigation::get();
            else
             $links=[];

             return successResponse($links);

        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()]);
        }
    }

        public function deadlines()
    {
        try {
           

            $deadlines=Deadline::orderBy("date","asc")->get();
            if(boula())
             return successResponse($deadlines);
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
                $deadline->delete();
            else if(isset($request->date))
                $deadline->update(["date"=>$request->date]);

            $deadlines=Deadline::orderBy("date","asc")->get();


            $data=["deadlines"=>$deadlines,"action"=>$request->action];

            return successResponse($data);


        } catch (Exception $e) {
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
}
