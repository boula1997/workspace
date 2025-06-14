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

            // Extract the year from the selected date
            $year = $date->year;

            // Initialize monthly income array
            $monthlyIncomeArray = [];

            $yearTotalIncome=0;
            $yearTotalOutcome=0;
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

                $monthlyIncomeArray[] = $monthlyIncome; // You can round() if needed
                $yearTotalIncome+= $monthlyIncome; // You can round() if needed
                $monthlyOutcomeArray[] = $monthlyOutcome*-1; // You can round() if needed
                $yearTotalOutcome+= $monthlyOutcome*-1; // You can round() if needed
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
            $selectedProjects = $projects->filter(fn($project) => rest($project) > 0)
                                        ->sortByDesc(fn($project) => rest($project));

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
