<?php

namespace App\Http\Controllers\Admin;

use App\Models\Task;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\TaskRequest;
use App\Models\Admin;
use App\Models\History;
use App\Models\Project;
use Exception;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    private $task;
    function __construct(Task $task)
    {
        $this->middleware('permission:task-list|task-create|task-edit|task-delete', ['only' => ['index', 'show']]);
        $this->middleware('permission:task-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:task-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:task-delete', ['only' => ['destroy']]);
        $this->task = $task;
    }

    public function updateKeywords(Request $request)
    {
        $theTask = Task::findOrFail($request->task_id);
        $tasks = Task::where('title', $theTask->title)->get();
        foreach ($tasks as $task) {
            $task->keywords = $request->keywords;
            $task->save();

            clearTasks($task->title);
        }
        return response()->json(['success' => 'updated successfully']);
    }



    public function index()
    {
        try {
            $employees = Admin::orderBy('name', 'ASC')->get();
            $projects = Project::where("status","!=",0)->orWhere("deal",0)->latest()->get();
            $projectIds = activeWebsitesIds();
            $employeeIds = isset($request->employees) ? $request->employees : [];

            // Determine status based on route
            if (request()->query('taskType')=="finishedTasks") {
                $status = [1];
            } elseif (request()->query('taskType')=="tasks") {
                $status = [0];
            } else {
                $status = [0, 1];
            }


            // Fetch tasks based on user permissions
            if (auth()->user()->email != "nessimboula@gmail.com") {
                $tasks = $this->task
                    ->whereIn('status', $status)
                    ->whereDoesntHave('employee', function ($query) {
                        $query->where('email', 'nessimboula@gmail.com');
                    })->where('status',$status)
                    ->latest()
                    
                    ->get()
                    ->unique('title');
            } else {
                $tasks = $this->task
                    ->whereIn('status', $status)
                    ->orderBy('status')
                    ->latest()
                    
                    ->get()
                    ->unique('title');
            }

            if (boula()) {

                // Find the last task ID
                $lastTaskId = $tasks->max('id') ?? 0;

                // Fetch active website titles
                $websites = Project::whereIn('id', $projectIds)->latest()->pluck('title');

                // Append active websites as new tasks with unique incremental IDs
                // foreach ($websites as $key => $value) {
                //     $lastTaskId++; // Increment ID for each new website task
                //     $tasks->push((object) [
                //         'id' => $lastTaskId,
                //         'title' => 'Doing some task or updating tasks for ' . $value,
                //         'keywords' => null,
                //         'status' => 0,
                //         'employee_id' => 1,
                //         'project_id' => 3,
                //         'counter' => 20,
                //         'level' => 0,
                //         'piority' => 0,
                //         'created_at' => null,
                //         'updated_at' => null
                //     ]);
                // }
            }

            return view('admin.crud.tasks.index', compact('tasks', 'employees', 'projects', 'projectIds', 'employeeIds'))
            ->with([
                'i' => (request()->input('page', 1) - 1) * 5,
                'taskType' => request()->query('taskType'), // for example
            ]);
        } catch (Exception $e) {
            dd($e->getMessage());
            return redirect()->back()->with(['error' => __('general.something_wrong')]);
        }
    }



    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $employees = Admin::orderBy('name', 'ASC')->get();
        $projects = Project::where("status","!=",0)->orWhere("deal",0)->latest()->get();
        return view('admin.crud.tasks.create', compact('employees', 'projects'));
    }


    public function getActiveWebsites()
    {
        $websites = Project::where('status', '!=', 0)->latest()->pluck('title');
        return response()->json($websites);
    }
    public function bulkAction(Request $request)
    {
        $taskIds = $request->input('tasks');
        $action = $request->input('action');
        $employees = Admin::orderBy('name', 'ASC')->get();
        $projects = Project::where("status","!=",0)->orWhere("deal",0)->latest()->get();
        // loadActiveProjects(isset($request->projects)?$request->projects:[]);
        $projectIds = activeWebsitesIds();
        $employeeIds = isset($request->employees) ? $request->employees : [];

        if (request()->taskType=="finishedTasks") {
            $status = [1];
        } elseif (request()->taskType=="tasks") {
            $status = [0];
        } else {
            $status = [0, 1];
        }
        


        if (!isset($request->employees) && $action == 'assign')
            dd("Select Employee!");

        if (!isset($request->projects) && $action == 'filterProject')
            dd("Select Project!");
        if (isset($taskIds)) {
            $task = Task::whereIn('id', $taskIds)->first();
            $tasks = Task::whereIn('id', $taskIds)->get();
        } else {
            $tasks = [];
        }
        if ($action == 'assign') {
            foreach ($tasks as $task) {
                $taskssameTitles = Task::where('title', $task->title)->get();
                foreach ($taskssameTitles as $tasksameTitle) {
                    foreach ($request->employees as $employee) {
                        Task::create([
                            'title' => $tasksameTitle->title,
                            'employee_id' => $employee,
                            'project_id' => $tasksameTitle->project_id,
                            'keywords' => $tasksameTitle->keywords
                        ]);
                    }
                    $tasksameTitle->delete();



                }
                clearTasks($task->title);
            }


            $tasks = Task::whereIn('status',$status)->whereIn('project_id', $request->projects)
                ->orderBy('project_id', 'desc')
                ->latest('created_at') // Ensure latest tasks by creation date
                 // Limit the results to 300
                ->get()
                ->unique('title');

             

            if (boula()) {

                // Find the last task ID
                $lastTaskId = $tasks->max('id') ?? 0;

                // Fetch active website titles
                $websites = Project::whereIn('id', $projectIds)->latest()->pluck('title');

                // Append active websites as new tasks with unique incremental IDs
                foreach ($websites as $key => $value) {
                    $lastTaskId++; // Increment ID for each new website task
                    // $tasks->push((object) [
                    //     'id' => $lastTaskId,
                    //     'title' => 'Doing some task or updating tasks for ' . $value,
                    //     'keywords' => null,
                    //     'status' => 0,
                    //     'employee_id' => 1,
                    //     'project_id' => 3,
                    //     'counter' => 20,
                    //     'level' => 0,
                    //     'piority' => 0,
                    //     'created_at' => null,
                    //     'updated_at' => null
                    // ]);
                }
            }


            return view('admin.crud.tasks.index', compact('tasks', 'employees', 'projects', 'projectIds', 'employeeIds'))
            ->with([
                'i' => (request()->input('page', 1) - 1) * 5,
                'taskType' => request()->query('taskType'), // for example
            ]);
        } elseif ($action == 'reassign') {
            foreach ($tasks as $task) {
                $taskssameTitles = Task::where('title', $task->title)->get();
                foreach ($taskssameTitles as $tasksameTitle) {
                    foreach ($request->employees as $employee) {
                        History::where('employee_id', $employee)->where('task_id', $tasksameTitle->id)->delete();
                        Task::create([
                            'title' => $tasksameTitle->title,
                            'employee_id' => $employee,
                            'project_id' => $tasksameTitle->project_id,
                            'keywords' => $tasksameTitle->keywords
                        ]);
                    }
                    // $tasksameTitle->delete();



                }
                clearTasks($task->title);
            }


            $tasks = Task::whereIn('status',$status)->whereIn('project_id', $request->projects)
                ->orderBy('project_id', 'desc')
                ->latest('created_at') // Ensure latest tasks by creation date
                 // Limit the results to 300
                ->get()
                ->unique('title');

            if (boula()) {

                // Find the last task ID
                $lastTaskId = $tasks->max('id') ?? 0;

                // Fetch active website titles
                $websites = Project::whereIn('id', $projectIds)->latest()->pluck('title');

                // Append active websites as new tasks with unique incremental IDs
                foreach ($websites as $key => $value) {
                    $lastTaskId++; // Increment ID for each new website task
                    // $tasks->push((object) [
                    //     'id' => $lastTaskId,
                    //     'title' => 'Doing some task or updating tasks for ' . $value,
                    //     'keywords' => null,
                    //     'status' => 0,
                    //     'employee_id' => 1,
                    //     'project_id' => 3,
                    //     'counter' => 20,
                    //     'level' => 0,
                    //     'piority' => 0,
                    //     'created_at' => null,
                    //     'updated_at' => null
                    // ]);
                }
            }

            return view('admin.crud.tasks.index', compact('tasks', 'employees', 'projects', 'projectIds', 'employeeIds'))
            ->with([
                'i' => (request()->input('page', 1) - 1) * 5,
                'taskType' => request()->query('taskType'), // for example
            ]);
        } elseif ($action == 'delete') {
            $tasks = Task::whereIn('id', $taskIds)->get();
            foreach ($tasks as $task) {
                // notAllowedTaskAction($task->title);
                if ($task->status == 1)
                    Task::where('title', $task->title)->update(['status' => !$task->status]);
                else
                    Task::where('title', $task->title)->update(['status' => !$task->status]);
                clearTasks($task->title);
            }
            ;
            if(isset($request->projects))
            $tasks = Task::whereIn('status',$status)->whereIn('project_id', $request->projects)
                ->orderBy('project_id', 'desc')
                ->latest('created_at') // Ensure latest tasks by creation date
                 // Limit the results to 300
                ->get()
                ->unique('title');
                
                else
                $tasks = Task::whereIn('status',$status)
                    ->orderBy('project_id', 'desc')
                    ->latest('created_at') // Ensure latest tasks by creation date
                     // Limit the results to 300
                    ->get()
                    ->unique('title');

            if (boula()) {

                // Find the last task ID
                $lastTaskId = $tasks->max('id') ?? 0;

                // Fetch active website titles
                $websites = Project::whereIn('id', $projectIds)->latest()->pluck('title');

                // Append active websites as new tasks with unique incremental IDs
                foreach ($websites as $key => $value) {
                    $lastTaskId++; // Increment ID for each new website task
                    // $tasks->push((object) [
                    //     'id' => $lastTaskId,
                    //     'title' => 'Doing some task or updating tasks for ' . $value,
                    //     'keywords' => null,
                    //     'status' => 0,
                    //     'employee_id' => 1,
                    //     'project_id' => 3,
                    //     'counter' => 20,
                    //     'level' => 0,
                    //     'piority' => 0,
                    //     'created_at' => null,
                    //     'updated_at' => null
                    // ]);
                }
            }

            return view('admin.crud.tasks.index', compact('tasks', 'employees', 'projects', 'projectIds', 'employeeIds'))
            ->with([
                'i' => (request()->input('page', 1) - 1) * 5,
                'taskType' => request()->query('taskType'), // for example
            ]);
        } else if ($action == 'filterProject') {

            $tasks = Task::whereIn('project_id', $request->projects)->whereIn('status', $status)->orderBy('project_id', 'desc')->get()->unique('title');
                $employees = Admin::orderBy('name', 'ASC')->get();
            $projects = Project::whereHas('tasks', function ($query) {
                $query->whereNotNull('id'); // Ensures tasks exist
            })->orderBy('title', 'ASC')->get();
            $type = $request->route_name;

            if (boula()) {

                // Find the last task ID
                $lastTaskId = $tasks->max('id') ?? 0;

                // Fetch active website titles
                $websites = Project::whereIn('id', $request->projects)->latest()->pluck('title');

                // Append active websites as new tasks with unique incremental IDs
                foreach ($websites as $key => $value) {
                    $lastTaskId++; // Increment ID for each new website task
                    // $tasks->push((object) [
                    //     'id' => $lastTaskId,
                    //     'title' => 'Doing some task or updating tasks for ' . $value,
                    //     'keywords' => null,
                    //     'status' => 0,
                    //     'employee_id' => 1,
                    //     'project_id' => 3,
                    //     'counter' => 20,
                    //     'level' => 0,
                    //     'piority' => 0,
                    //     'created_at' => null,
                    //     'updated_at' => null
                    // ]);
                }
            }
            return view('admin.crud.tasks.index', compact('tasks', 'employees', 'projects', 'type', 'projectIds', 'employeeIds'))
            ->with([
                'i' => (request()->input('page', 1) - 1) * 5,
                'taskType' => request()->route('    '), // for example
            ]);
        }



        return redirect()->back()->with('error', __('Invalid action selected.'));
    }




    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
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

                    ]);
                }
            }

            // Get the previous and the one before the previous route
            $previousRoute = session('previousRoute');
            $twoRoutesAgo = session('twoRoutesAgo');


            // Redirect to either the previous or the one before
            return redirect($twoRoutesAgo)
                ->with(['success' => __('general.created_successfully')]);

        } catch (Exception $e) {
            dd($e->getMessage());
            return redirect()->back()->with(['error' => __('general.something_wrong')]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function show(Task $task)
    {
        return view('admin.crud.tasks.show', compact('task'));
    }

    public function toggleLevel($id)
    {
        try {
            // Find and toggle the level for the given task ID
            $task = Task::find($id);
            $task->where('title', $task->title)->update(['level' => !$task->level]);



           return response()->json(['data' => $task->level == 0 ? 'mobile' : 'pc']);
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()]);
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


    public function updateCounter(Request $request)
    {



        $taskId = $request->query('task_id'); // Retrieve query parameter
        $remainingTime = $request->query('counter'); // Retrieve query parameter

        // Update the task in the database (example)
        $task = Task::find($taskId);
        if ($task->counter == 0)
            return response()->json(['status' => 'error', 'message' => 'Task is finished'], 404);

        if ($task) {
            $task->counter = $remainingTime;
            // $task->save();

            return response()->json(['status' => 'success', 'message' => 'Task counter updated']);
        }

        return response()->json(['status' => 'error', 'message' => 'Task not found'], 404);
    }



    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function edit(Task $task)
    {
        //    dd($task->title);
        $employees = Admin::orderBy('name', 'ASC')->get();
        $projects = Project::where("status","!=",0)->orWhere("deal",0)->latest()->get();
        $selectedEmployees = Task::where('title', $task->title)->pluck('employee_id')->toArray();
        return view('admin.crud.tasks.edit', compact('task', 'employees', 'projects', 'selectedEmployees'));
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\portfolio  $task
     * @return \Illuminate\Http\Response
     */
    public function update(TaskRequest $request, Task $task)
    {
        try {

            foreach ($request->employees as $employee) {
                Task::create([
                    'title' => $request->title,
                    'employee_id' => $employee,
                    'project_id' => $request->project_id,
                    'keywords' => $task->keywords,
                    'piority' => $request->piority,

                ]);
            }
            $task->delete();




            // Get the previous and the one before the previous route
            $previousRoute = session('previousRoute');
            $twoRoutesAgo = session('twoRoutesAgo');

            // Redirect to either the previous or the one before
            return redirect($twoRoutesAgo)
                ->with(['success' => __('general.updated_successfully')]);
        } catch (Exception $e) {
            dd($e->getMessage());
            return redirect()->back()->with(['error' => __('general.something_wrong')]);
        }
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function destroy(Task $task)
    {
        try {
            $task->update([
                'status' => !$task->status,
                'created_at' => now() // or use Carbon::now()
            ]);




            return redirect()->back()->with(['success' => __('general.created_successfully')]);
        } catch (Exception $e) {
            dd($e->getMessage());
            return redirect()->back()->with(['error' => __('general.something_wrong')]);
        }
    }
}
