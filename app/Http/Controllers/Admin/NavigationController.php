<?php

namespace App\Http\Controllers\Admin;

use App\Models\Navigation;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\NavigationRequest;
use App\Models\Admin;
use App\Models\Project;
use Exception;

class NavigationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    private $navigation;
    function __construct(Navigation $navigation)
    {
        $this->middleware('permission:navigation-list|navigation-create|navigation-edit|navigation-delete', ['only' => ['index', 'show']]);
        $this->middleware('permission:navigation-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:navigation-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:navigation-delete', ['only' => ['destroy']]);
        $this->navigation = $navigation;
    }


    public function index()
    {
        try {
            $employees=Admin::orderBy('name', 'ASC')->get();

  

            $navigations = $this->navigation
                ->latest()
                ->get()
                ->unique('title');

            return view('admin.crud.navigations.index', compact('navigations','employees'))
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
        return view('admin.crud.navigations.create',compact('employees'));
    }
    public function bulkAction(Request $request)
    {

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
            $navigations = Navigation::whereDate('created_at', '>=', $startdate)
                                 ->whereDate('created_at', '<=', $enddate)
                                 ->when($difficulty, function ($query, $difficulty) {
                                     return $query->where('difficulty', $difficulty);
                                 })
                                 ->when($hasPhone, function ($query, $hasPhone) {
                                     return $query->where('hasPhone', $hasPhone);
                                 })
                                 ->get()
                                 ->unique('title');
        
            return view('admin.crud.navigations.index', compact('navigations', 'employees'))
                ->with('i', (request()->input('page', 1) - 1) * 5);
        }
        
        
        $navigationIds = $request->input('navigations');
         
        if(!isset($request->employees)&& $action == 'assign')
        return redirect()->back()->with('error', __('Select Employee!'));
    
        $navigation=Navigation::whereIn('id', $navigationIds)->first();
        $navigations=Navigation::whereIn('id', $navigationIds)->get();
        if ($action == 'assign') {
            foreach($navigations as $navigation) {
                $navigationssameTitles=Navigation::where('title', $navigation->title)->get();
                foreach($navigationssameTitles as $navigationsameTitle){
                    foreach($request->employees as $employee){
                    Navigation::create([
                        'title'=>$navigationsameTitle->title,
                        'employee_id'=>$employee,
                    ]);
                }
                $navigationsameTitle->delete();
             }
            }
            return redirect()->back()->with('success', __('Navigations assigned successfully.'));
        } elseif ($action == 'delete') {
            $navigations=Navigation::whereIn('id', $navigationIds)->get();
            foreach($navigations as $navigation) {
             Navigation::where('title',$navigation->title)->update(['status' => !$navigation->status]);
            }; 
            return redirect()->back()->with('success', __('Navigations deleted successfully.'));
        }
    
        return redirect()->back()->with('error', __('Invalid action selected.'));
    }
    

    

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(NavigationRequest $request)
    {
        try {
            $titles = explode('+', $request->title);
            $data['difficulty']=$request->has('difficulty')?1:0;
            $data['hasPhone']=$request->has('hasPhone')?1:0;
            foreach ($titles as $title) {
                foreach ($request->employees as $employee) {
                    Navigation::create([
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
     * @param  \App\Models\Navigation  $navigation
     * @return \Illuminate\Http\Response
     */
    public function show(Navigation $navigation)
    {
        return view('admin.crud.navigations.show', compact('navigation'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Navigation  $navigation
     * @return \Illuminate\Http\Response
     */
    public function edit(Navigation $navigation)
    {
        //    dd($navigation->title);
        $employees=Admin::orderBy('name', 'ASC')->get();
        $projects=Project::where('status',1)->get();
        $selectedEmployees=Navigation::where('title',$navigation->title)->pluck('employee_id');;
        return view('admin.crud.navigations.edit', compact('navigation','employees','projects','selectedEmployees'));
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\portfolio  $navigation
     * @return \Illuminate\Http\Response
     */
    public function update(NavigationRequest $request, Navigation $navigation)
    {
        try {
            $data = $request->except('employees');
            $data['difficulty']=$request->has('difficulty')?1:0;
            $data['hasPhone']=$request->has('hasPhone')?1:0;
            $navigations=Navigation::where('title',$navigation->title)->get();
            foreach($navigations as $navigation) 
            $navigation->update($data);
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
     * @param  \App\Models\Navigation  $navigation
     * @return \Illuminate\Http\Response
     */
    public function destroy(Navigation $navigation)
    {
        try {
            $navigation->update([
                'status' => !$navigation->status,
                'created_at' => now() // or use Carbon::now()
            ]);
            return redirect()->back()->with(['success' => __('general.created_successfully')]);
        } catch (Exception $e) {
            dd($e->getMessage());
            return redirect()->back()->with(['error' => __('general.something_wrong')]);
        }
    }
}
