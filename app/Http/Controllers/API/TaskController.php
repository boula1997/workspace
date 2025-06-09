<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\TaskRequest;
use App\Http\Resources\ProjectResource;
use App\Http\Resources\TaskResource;
use App\Models\Project;
use App\Models\Admin;
use App\Models\Fee;
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
        $projects = Project::where("status","!=",0)->orWhere("deal",0)->latest()->get();

        $tasks = Task::where("status", 0)
            ->orderBy('piority', 'desc') // Then by priority (descending)
            ->orderBy('project_id', 'asc') // Order by project first
            ->latest('updated_at') // Then by creation date (latest first)
            ->take(300) // Limit to 300 tasks
            ->get()
            ->unique('title'); // Remove duplicate tasks by title
        $data=[
            "projects"=>ProjectResource::collection($projects),
            "employees"=>$employees,
            "tasks"=>TaskResource::collection($tasks),
            "last_time"=>setting()->last_time . ' '.getTimeAgo(setting()->last_time). "\n" .'Allowed in: '. date('Y-m-d', strtotime(setting()->last_time . ' + 3 days')). "\n".activeDeadline()["action"]."\n".activeDeadline()["deadline"],

        ];

        return successResponse($data);
    }
    public function stats($date = null)
    {
        // Use today's date if none is provided
        $date = request()->query('date') ? Carbon::parse(request()->query('date')) : Carbon::now();
        $startOfMonth = $date->copy()->startOfMonth();
        $endOfMonth = $date->copy()->endOfMonth();

        // Query the fees for the specific month
        $avgFees = Fee::whereBetween('created_at', [$startOfMonth, $endOfMonth])->sum('amount');

        $incomeFees = Fee::where('amount', '>', 0)
            ->whereBetween('created_at', [$startOfMonth, $endOfMonth])
            ->sum('amount');
        $outcomeFees = Fee::where('amount', '<', 0)
            ->whereBetween('created_at', [$startOfMonth, $endOfMonth])
            ->sum('amount');
        
        // Query all fees
        $allavgFees = Fee::sum('amount');
        $allincomeFees = Fee::where("amount",">",0)->sum('amount');
        $alloutcomeFees = Fee::where("amount","<",0)->sum('amount');

        // Retrieve the latest projects
        $projects = Project::latest()->get();

    // Filter and sort projects by rest
    $selectedProjects = $projects->filter(function ($project) {
        return rest($project) > 0; // Include only projects with positive rest
    })->sortByDesc(function ($project) {
        return rest($project); // Sort by rest in descending order
    });

        // Prepare data for the response
        $data = [
            "projects" => ProjectResource::collection($selectedProjects),
            "avgFees" => $avgFees,
            "incomeFees" => $incomeFees,
            "outcomeFees" => $outcomeFees,
            "allavgFees" => $allavgFees,
            "alloutcomeFees" => $alloutcomeFees,
            "last_time" => setting()->last_time . ' ' . getTimeAgo(setting()->last_time) . "\n" .
                'Allowed in: ' . date('Y-m-d', strtotime(setting()->last_time . ' + 3 days')) . "\n" .
                activeDeadline()["action"] . "\n" . activeDeadline()["deadline"],
        ];

        return successResponse($data);
    }




    public function createFinished()
    {
        $employees = Admin::orderBy('name', 'ASC')->get();
        $projects = Project::where("status","!=",0)->orWhere("deal",0)->latest()->get();

        $tasks = Task::where("status", 1)
            ->orderBy('piority', 'desc') // Then by priority (descending)
            ->orderBy('project_id', 'asc') // Order by project first
            ->latest('updated_at') // Then by creation date (latest first)
            ->take(300) // Limit to 300 tasks
            ->get()
            ->unique('title'); // Remove duplicate tasks by title
        $data=[
            "projects"=>ProjectResource::collection($projects),
            "employees"=>$employees,
            "tasks"=>TaskResource::collection($tasks),
            "last_time"=>setting()->last_time . ' '.getTimeAgo(setting()->last_time).' Allowed in: '. date('Y-m-d', strtotime(setting()->last_time . ' + 3 days')),

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
}
