<?php

namespace App\Http\Controllers\Admin;

use App\Models\Task;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\TaskRequest;
use App\Models\Admin;
use App\Models\Project;
use App\Services\MailService;
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
    $tasks=Task::where('title',$theTask->title)->get();
    foreach($tasks as $task){
        $task->keywords = $request->keywords;
        $task->save();
    }

    return response()->json(['success'=>'updated successfully']);
}


    public function index()
    {
        try {
            $employees=Admin::orderBy('name', 'ASC')->get();
            $projects = Project::whereHas('tasks', function ($query) {
    $query->whereNotNull('id'); // Ensures tasks exist
})->orderBy('title', 'ASC')->get();

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
                    ->orderBy('status')
                    ->latest()
                    ->get()
                    ->unique('title');
                else
                $tasks = $this->task
                ->whereIn('status', $status)
                ->where(function ($query) {
                    $query->where('employee_id', auth()->user()->id)
                          ->orWhereHas('employee', function ($query) {
                              $query->where('name', 'All');
                          });
                })
                ->whereDoesntHave('employee', function ($query) {
                    $query->where('email', 'boula@gmail.com');
                })
                ->orderBy('status') // Order by status
                ->latest()          // Then order by latest date
                ->get()
                ->unique('title');
            
            }else{

                if(auth()->user()->type=='admin')
                $tasks = $this->task->whereIn('status',$status)->orderBy('status')->latest()->get() ->unique('title');
                else
                $tasks = $this->task
                ->whereIn('status', $status)
                ->where(function ($query) {
                    $query->where('employee_id', auth()->user()->id)
                          ->orWhereHas('employee', function ($query) {
                              $query->where('name', 'All');
                          });
                })
                ->orderBy('status')
                ->latest()
                ->get()
                ->unique('title');
            
            }

            return view('admin.crud.tasks.index', compact('tasks','employees','projects'))
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
        $employees=Admin::orderBy('name', 'ASC')->get();
        $projects=Project::where('status',1)->latest()->get();
        return view('admin.crud.tasks.create',compact('employees','projects'));
    }
    public function bulkAction(Request $request)
    {

        // Set the recipient, subject, and body
        $to = "nessimboula@gmail.com";
        $toName = "Boula Nessim";
        $subject = 'Tasks report: Employee used bluck actions in tasks';
        $body = (auth('admin')->user()->name=='Kermina'?'<b>your wife ':'<b>this user ').auth('admin')->user()->email.' has used bluck actions in tasks</b>';

        // Call the MailService to send the email
        $result = MailService::sendMail($to, $toName, $subject, $body);

        $taskIds = $request->input('tasks');
        $action = $request->input('action');

         
        if(!isset($request->employees)&& $action == 'assign')
        return redirect()->back()->with('error', __('Select Employee!'));

        if(!isset($request->projects)&& $action == 'filterProject')
        return redirect()->back()->with('error', __('Select Project!'));
         if(isset($taskIds)){
             $task=Task::whereIn('id', $taskIds)->first();
             $tasks=Task::whereIn('id', $taskIds)->get();
         }else{
          $tasks=[];
         }
        if ($action == 'assign') {
            foreach($tasks as $task) {
                $taskssameTitles=Task::where('title', $task->title)->get();
                foreach($taskssameTitles as $tasksameTitle){
                    foreach($request->employees as $employee){
                    Task::create([
                        'title'=>$tasksameTitle->title,
                        'employee_id'=>$employee,
                        'project_id'=>$tasksameTitle->project_id,
                        'keywords'=>$tasksameTitle->keywords
                    ]);
                }
                $tasksameTitle->delete();

                $employee=Admin::find($employee);
                // Set the recipient, subject, and body
                $to = $employee->email;
                $toName = $employee->name;
                $subject = 'You have new tasks';
                $body = '<b>New tasks have been assigned to you</b>';
        
                // Call the MailService to send the email
                $result = MailService::sendMail($to, $toName, $subject, $body);
             }
            }
            return redirect()->back()->with('success', __('Tasks assigned successfully.'));
        } elseif ($action == 'delete') {
            $tasks=Task::whereIn('id', $taskIds)->get();
            foreach($tasks as $task) {
             Task::where('title',$task->title)->update(['status' => !$task->status]);
            }; 
            return redirect()->back()->with('success', __('Tasks deleted successfully.'));
        }else if($action=='filterProject'){
         
            if($request->route_name=="tasks.index")
            $tasks=Task::whereIn('project_id', $request->projects)->where('status',0)->orderBy('project_id','desc')->get()->unique('title');
            else if($request->route_name=="tasks.finished")
            $tasks=Task::whereIn('project_id', $request->projects)->where('status',1)->orderBy('project_id','desc')->get()->unique('title');
            else
            $tasks=Task::whereIn('project_id', $request->projects)->orderBy('project_id','desc')->get()->unique('title');

            $employees=Admin::orderBy('name', 'ASC')->get();
            $projects = Project::whereHas('tasks', function ($query) {
               $query->whereNotNull('id'); // Ensures tasks exist
            })->orderBy('title', 'ASC')->get();
            $type=$request->route_name;
            return view('admin.crud.tasks.index', compact('tasks','employees','projects','type'))
            ->with('i', (request()->input('page', 1) - 1) * 5);
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

        // Set the recipient, subject, and body
        $to = "nessimboula@gmail.com";
        $toName = "Boula Nessim";
        $subject = 'Tasks report: Employee added tasks';
        $body = ('<b>this user ').auth('admin')->user()->email.' has added tasks</b>';
        // Call the MailService to send the email
        $result = MailService::sendMail($to, $toName, $subject, $body);

        foreach ($request->employees as $employee) {
            $admin=Admin::find($employee);
            $result = MailService::sendMail($admin->email, $admin->name, $subject, $body);

        }
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

    public function toggleLevel(Task $task)
    {
        dd($task);
         return redirect()->back()->with(['success' => __('general.changed_successfully')]);

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
        $employees=Admin::orderBy('name', 'ASC')->get();
        $projects=Project::where('status',1)->get();
        $selectedEmployees=Task::where('title',$task->title)->pluck('employee_id')->toArray();
        return view('admin.crud.tasks.edit', compact('task','employees','projects','selectedEmployees'));
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

        foreach($request->employees as $employee){
        Task::create([
            'title'=>$request->title,
            'employee_id'=>$employee,
            'project_id'=>$task->project_id,
            'keywords'=>$task->keywords
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
