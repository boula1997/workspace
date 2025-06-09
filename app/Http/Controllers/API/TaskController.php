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
public function stats(Request $request)
{
    // Parse the date from the request
    $date = Carbon::parse($request->date); // Use parse if the date is a full date
    $startOfMonth = $date->startOfMonth();
    $endOfMonth = $date->endOfMonth();

    // Get the current month's start and end dates
    $startOfCurrentMonth = Carbon::now()->startOfMonth();
    $endOfCurrentMonth = Carbon::now()->endOfMonth();

    // Query the fees for the specific month
    $monthFees = Fee::whereBetween('created_at', [$startOfMonth, $endOfMonth])->sum('amount');
    // Query the fees for the current month
    $currentMonthFees = Fee::whereBetween('created_at', [$startOfCurrentMonth, $endOfCurrentMonth])->sum('amount');
    // Query all fees
    $allFees = Fee::sum('amount');

    // Retrieve the latest projects
    $projects = Project::latest()->get();
    $selectedProjects = [];
    foreach ($projects as $project) {
        if (rest($project) > 0) {
            array_push($selectedProjects, $project);
        }
    }

    // Prepare data for the response
    $data = [
        "projects" => ProjectResource::collection($projects),
        "monthFees" => $monthFees,
        "currentMonthFees" => $currentMonthFees,
        "allFees" => $allFees,
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
