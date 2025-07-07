<?php

namespace App\Http\Controllers\Admin;

use App\Models\Fee;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\FeeRequest;
use App\Models\Admin;
use App\Models\Project;
use Exception;

class FeeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    private $fee;
    function __construct(Fee $fee)
    {
        $this->middleware('permission:fee-list|fee-create|fee-edit|fee-delete', ['only' => ['index', 'show']]);
        $this->middleware('permission:fee-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:fee-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:fee-delete', ['only' => ['destroy']]);
        $this->fee = $fee;
    }


    public function index()
    {
        try {

            $fees = $this->fee->latest()->get();
            return view('admin.crud.fees.index', compact('fees'))
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
        $projects=Project::latest()->get();
        return view('admin.crud.fees.create',compact('projects'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(FeeRequest $request)
    {
        try {
            $project=Project::find($request->project_id);
            $latestFee = $project->feeses()->latest()->first();
            // if(($latestFee ? $latestFee->rest : $project->cost)-$request->amount<0)
            // return redirect()->back()->with(['error' => __('amount exceeded the cost')]);

                Fee::create([
                    'amount' => $request->amount,
                    'project_id' => $request->project_id,
                    'note' => $request->note,
                ]);
    
            // Get the previous and the one before the previous route
            $previousRoute = session('previousRoute');
            $twoRoutesAgo = session('twoRoutesAgo');
    
            // Redirect to either the previous or the one before
            return redirect()->route('fees.index')
                ->with(['success' => __('general.created_successfully')]);
    
        } catch (Exception $e) {
            dd($e->getMessage());
            return redirect()->back()->with(['error' => __('general.something_wrong')]);
        }
    }
    
    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Fee  $fee
     * @return \Illuminate\Http\Response
     */
    public function show(Fee $fee)
    {
        return view('admin.crud.fees.show', compact('fee'));
    }
    
    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Fee  $fee
     * @return \Illuminate\Http\Response
     */
    public function edit(Fee $fee)
    {
        $projects=Project::latest()->get();
        return view('admin.crud.fees.edit', compact('fee','projects'));
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\portfolio  $fee
     * @return \Illuminate\Http\Response
     */
    public function update(FeeRequest $request, Fee $fee)
    {
        try {
            // return redirect()->back()->with(['error' => __('amount exceeded the cost')]);

            $latestFee = $fee->project->feeses()->latest()->first();
            
            // if(($latestFee ? $latestFee->rest : $fee->project->cost)-($fee->amount-$request->amount)<0)
     
            $fee->update([
                'amount' => $request->amount,
                'note' => $request->note,
                'project_id' => $request->project_id,
            ]);
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
     * @param  \App\Models\Fee  $fee
     * @return \Illuminate\Http\Response
     */
    public function destroy(Fee $fee)
    {
        try {
            $fee->delete();
            return redirect()->back()->with(['success' => __('general.created_successfully')]);
        } catch (Exception $e) {
            dd($e->getMessage());
            return redirect()->back()->with(['error' => __('general.something_wrong')]);
        }
    }
}
