<?php

namespace App\Http\Controllers\Admin;

use App\Models\Task;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\TaskRequest;
use App\Models\Admin;
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


    public function index()
    {
        try {
            $employees=Admin::get();

            if(request()->routeIs('tasks.finished'))
            $status=[1];
            else if(request()->routeIs('tasks.index'))
            $status=[0];
            else
            $status=[0,1];

            if(auth()->user()->email!="boula@gmail.com"){
                if(auth()->user()->type=='admin')
                $tasks = $this->task
                    ->whereIn('status', $status)
                    ->whereDoesntHave('employee', function ($query) {
                        $query->where('email', 'boula@gmail.com');
                    })
                    ->latest()
                    ->get()
                    ->unique('title');
                else
                $tasks = $this->task
                ->whereIn('status', $status)
                ->where('employee_id', auth()->user()->id)
                ->whereDoesntHave('employee', function ($query) {
                    $query->where('email', 'boula@gmail.com');
                })
                ->latest()
                ->get()
                ->unique('title');
            }else{

                if(auth()->user()->type=='admin')
                $tasks = $this->task->whereIn('status',$status)->latest()->get() ->unique('title');
                else
                $tasks = $this->task->whereIn('status',$status)->where('employee_id',auth()->user()->id)->latest()->get() ->unique('title');
            }
            return view('admin.crud.tasks.index', compact('tasks','employees'))
                ->with('i', (request()->input('page', 1) - 1) * 5);
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
        $employees=Admin::get();
        $projects=Project::where('status',1)->latest()->get();
        return view('admin.crud.tasks.create',compact('employees','projects'));
    }
    public function bulkAction(Request $request)
    {


        $taskIds = $request->input('tasks');
        $action = $request->input('action');
         
        if(!isset($request->employees)&& $action == 'assign')
        return redirect()->back()->with('error', __('Select Employee!'));
    
        $task=Task::whereIn('id', $taskIds)->first();
        $tasks=Task::whereIn('id', $taskIds)->get();
        if ($action == 'assign') {
            foreach($tasks as $task) {
                $taskssameTitles=Task::where('title', $task->title)->get();
                foreach($taskssameTitles as $tasksameTitle){
                    foreach($request->employees as $employee){
                    Task::create([
                        'title'=>$tasksameTitle->title,
                        'employee_id'=>$employee,
                        'project_id'=>$tasksameTitle->project_id
                    ]);
                }
                $tasksameTitle->delete();
             }
            }
            return redirect()->back()->with('success', __('Tasks assigned successfully.'));
        } elseif ($action == 'delete') {
            $tasks=Task::whereIn('id', $taskIds)->get();
            foreach($tasks as $task) {
             Task::where('title',$task->title)->update(['status' => !$task->status]);
            }; 
            return redirect()->back()->with('success', __('Tasks deleted successfully.'));
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
                        'project_id' => $request->project_id
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

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function edit(Task $task)
    {
        //    dd($task->title);
        $employees=Admin::get();
        $projects=Project::where('status',1)->get();
        return view('admin.crud.tasks.edit', compact('task','employees','projects'));
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
            $data = $request->all();
            $task->update($data);
            return redirect()->back()->with(['success' => __('general.created_successfully')]);
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
