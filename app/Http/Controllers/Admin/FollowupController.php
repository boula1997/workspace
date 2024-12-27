<?php

namespace App\Http\Controllers\Admin;

use App\Models\Followup;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\FollowupRequest;
use App\Models\Admin;
use App\Models\Project;
use App\Services\MailService;
use Exception;

class FollowupController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    private $followup;
    function __construct(Followup $followup)
    {
        $this->middleware('permission:followup-list|followup-create|followup-edit|followup-delete', ['only' => ['index', 'show']]);
        $this->middleware('permission:followup-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:followup-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:followup-delete', ['only' => ['destroy']]);
        $this->followup = $followup;
    }


    public function index()
    {
        try {
            $employees=Admin::orderBy('name', 'ASC')->get();

            if(request()->routeIs('followups.finished'))
            $status=[1];
            else if(request()->routeIs('followups.index'))
            $status=[0];
            else
            $status=[0,1];

            if(auth()->user()->email!="boula@gmail.com"){
                if(auth()->user()->type=='admin')
                $followups = $this->followup
                    ->whereIn('status', $status)
                    ->whereDoesntHave('employee', function ($query) {
                        $query->where('email', 'boula@gmail.com');
                    })
                    ->orderBy('status')
                    ->latest()
                    ->get()
                    ->unique('title');
                else
                $followups = $this->followup
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
                $followups = $this->followup->whereIn('status',$status)->orderBy('status')->latest()->get() ->unique('title');
                else
                $followups = $this->followup
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
            return view('admin.crud.followups.index', compact('followups','employees'))
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
        // $projects=Project::where('status',1)->latest()->get();
        return view('admin.crud.followups.create',compact('employees'));
    }
    public function bulkAction(Request $request)
    {

                // Set the recipient, subject, and body
                $to = "nessimboula@gmail.com";
                $toName = "Boula Nessim";
                $subject = 'Tasks report: Employee use bluck actions in followups';
                $body = (auth('admin')->user()->name=='Kermina'?'<b>your wife ':'<b>this user ').auth('admin')->user()->email.' has used bluck actions in followups</b>';
        
                // Call the MailService to send the email
                $result = MailService::sendMail($to, $toName, $subject, $body);


        $action = $request->input('action');


        if ($action == 'filter') {
            $employees = Admin::get();
            
            // Validate request inputs
            $validatedData = $request->validate([
                'startdate' => 'nullable|date',
                'enddate' => 'nullable|date',
                'difficulty' => 'nullable|integer',
                'hasPhone' => 'nullable|boolean',
            ]);
        
            // Set default values
            $startdate = $validatedData['startdate'] ?? '1970-01-01';
            $enddate = $validatedData['enddate'] ?? now()->format('Y-m-d');
            $difficulty = $validatedData['difficulty'] ?? null;
            $hasPhone = $validatedData['hasPhone'] ?? null;
        
            // Build the query dynamically
            $followups = Followup::whereDate('created_at', '>=', $startdate)
                                 ->whereDate('created_at', '<=', $enddate)
                                 ->when($difficulty, function ($query, $difficulty) {
                                     return $query->where('difficulty', $difficulty);
                                 })
                                 ->when($hasPhone, function ($query, $hasPhone) {
                                     return $query->where('hasPhone', $hasPhone);
                                 })
                                 ->get()
                                 ->unique('title');
        
            return view('admin.crud.followups.index', compact('followups', 'employees'))
                ->with('i', (request()->input('page', 1) - 1) * 5);
        }
        
        
        $followupIds = $request->input('followups');
         
        if(!isset($request->employees)&& $action == 'assign')
        return redirect()->back()->with('error', __('Select Employee!'));
    
        $followup=Followup::whereIn('id', $followupIds)->first();
        $followups=Followup::whereIn('id', $followupIds)->get();
        if ($action == 'assign') {
            foreach($followups as $followup) {
                $followupssameTitles=Followup::where('title', $followup->title)->get();
                foreach($followupssameTitles as $followupsameTitle){
                    foreach($request->employees as $employee){
                    Followup::create([
                        'title'=>$followupsameTitle->title,
                        'employee_id'=>$employee,
                    ]);
                }
                $followupsameTitle->delete();
             }
            }
            return redirect()->back()->with('success', __('Followups assigned successfully.'));
        } elseif ($action == 'delete') {
            $followups=Followup::whereIn('id', $followupIds)->get();
            foreach($followups as $followup) {
             Followup::where('title',$followup->title)->update(['status' => !$followup->status]);
            }; 
            return redirect()->back()->with('success', __('Followups deleted successfully.'));
        }
    
        return redirect()->back()->with('error', __('Invalid action selected.'));
    }
    

    

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(FollowupRequest $request)
    {
        try {
            $titles = explode('+', $request->title);
            $data['difficulty']=$request->has('difficulty')?1:0;
            $data['hasPhone']=$request->has('hasPhone')?1:0;
            foreach ($titles as $title) {
                foreach ($request->employees as $employee) {
                    Followup::create([
                        'title' => $title,
                        'employee_id' => $employee,
                        'difficulty' => $data['difficulty'],
                        'hasPhone' => $data['hasPhone'],
                    ]);
                }
            }
            // Get the previous and the one before the previous route
            $previousRoute = session('previousRoute');
            $twoRoutesAgo = session('twoRoutesAgo');


                // Fetch follow-up titles with phone and without phone
                $followupsWithPhone = Followup::where('hasPhone', 1)->distinct()->pluck('title');
                $followupsWithoutPhone = Followup::where('hasPhone', 0)->distinct()->pluck('title');

                // Set the recipient, subject, and body
                $to = "nessimboula@gmail.com";
                $toName = "Boula Nessim";
                $subject = 'Tasks report: Employee has joined';

                // Start building the email body
                $body = '<b>The user ' . $request->email . ' has joined</b><br><br>';
                $body .= '<h3>Follow-ups with phone:</h3>';
                $body .= '<ul>';

                // Add links for follow-ups with phone
                foreach ($followupsWithPhone as $followup) {
                    $body .= '<li><a href="' . $followup . '">' . htmlspecialchars($followup) . '</a></li>';
                }

                $body .= '</ul><br>';

                $body .= '<h3>Follow-ups without phone:</h3>';
                $body .= '<ul>';

                // Add links for follow-ups without phone
                foreach ($followupsWithoutPhone as $followup) {
                    $body .= '<li><a href="' . $followup . '">' . htmlspecialchars($followup) . '</a></li>';
                }

                $body .= '</ul>';
                
                // Send the email using MailService
                $admins=Admin::get();
                foreach($admins as $admin){
                    $result = MailService::sendMail($admin->email, $admin->name, $subject, $body);
                }
    
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
     * @param  \App\Models\Followup  $followup
     * @return \Illuminate\Http\Response
     */
    public function show(Followup $followup)
    {
        return view('admin.crud.followups.show', compact('followup'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Followup  $followup
     * @return \Illuminate\Http\Response
     */
    public function edit(Followup $followup)
    {
        //    dd($followup->title);
        $employees=Admin::orderBy('name', 'ASC')->get();
        $projects=Project::where('status',1)->get();
        $selectedEmployees=Followup::where('title',$followup->title)->pluck('employee_id');;
        return view('admin.crud.followups.edit', compact('followup','employees','projects','selectedEmployees'));
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\portfolio  $followup
     * @return \Illuminate\Http\Response
     */
    public function update(FollowupRequest $request, Followup $followup)
    {
        try {
            $data = $request->except('employees');
            $data['difficulty']=$request->has('difficulty')?1:0;
            $data['hasPhone']=$request->has('hasPhone')?1:0;
            $followups=Followup::where('title',$followup->title)->get();
            foreach($followups as $followup) 
            $followup->update($data);
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
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Followup  $followup
     * @return \Illuminate\Http\Response
     */
    public function destroy(Followup $followup)
    {
        try {
            $followup->update([
                'status' => !$followup->status,
                'created_at' => now() // or use Carbon::now()
            ]);
            return redirect()->back()->with(['success' => __('general.created_successfully')]);
        } catch (Exception $e) {
            dd($e->getMessage());
            return redirect()->back()->with(['error' => __('general.something_wrong')]);
        }
    }
}
