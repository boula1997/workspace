<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\TaskRequest;
use App\Http\Resources\ProjectResource;
use App\Http\Resources\TaskResource;
use App\Models\Project;
use App\Models\Admin;
use App\Models\Task;
use Exception;
use Illuminate\Http\Request;

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

        $tasks = Task::where("status",0)->orderBy('active', 'desc')
                ->latest('created_at') // Ensure latest tasks by creation date
                 // Limit the results to 300
                ->get()
                ->unique('title');
        $data=[
            "projects"=>ProjectResource::collection($projects),
            "employees"=>$employees,
            "tasks"=>$tasks,
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
}
