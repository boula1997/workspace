<?php

namespace App\Http\Controllers\Admin;

use App\Models\History;
use App\Models\Admin;
use App\Models\Project;
use App\Models\Task;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\HistoryRequest;
use Exception;

class HistoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    private $history;
    function __construct(History $history)
    {
        $this->middleware('permission:history-list|history-create|history-edit|history-delete', ['only' => ['index', 'show']]);
        $this->middleware('permission:history-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:history-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:history-delete', ['only' => ['destroy']]);
        $this->history = $history;
    }


    public function index()
    {
        try {
            $historys = $this->history->latest()->get();
            $employees=Admin::get();
            $projects=Project::get();
            return view('admin.crud.historys.index', compact('historys','employees','projects'));
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
    {$employees=Admin::get();
        return view('admin.crud.historys.create',compact('employees'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(HistoryRequest $request)
    {
        try {
            $this->history->create($request->all());
            return redirect()->route('historys.index')
                ->with('success', trans('general.created_successfully'));
        } catch (Exception $e) {
            dd($e->getMessage());
            return redirect()->back()->with(['error' => __('general.something_wrong')]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\History  $history
     * @return \Illuminate\Http\Response
     */
    public function show(History $history)
    {
        return view('admin.crud.historys.show', compact('history'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\History  $history
     * @return \Illuminate\Http\Response
     */
    public function edit(History $history)
    {
        //    dd($history->title);
        $employees=Admin::get();
        return view('admin.crud.historys.edit', compact('history','employees'));
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\portfolio  $history
     * @return \Illuminate\Http\Response
     */
    public function update(HistoryRequest $request, History $history)
    {
        try {
            $data = $request->all();
            $history->update($data);
            return redirect()->route('historys.index')
                ->with('success', trans('general.update_successfully'));
        } catch (Exception $e) {
            dd($e->getMessage());
            return redirect()->back()->with(['error' => __('general.something_wrong')]);
        }
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\History  $history
     * @return \Illuminate\Http\Response
     */
    public function destroy(History $history)
    {
        try {
            $history->delete();
            return redirect()->route('historys.index')
                ->with('success', trans('general.deleted_successfully'));
        } catch (Exception $e) {
            dd($e->getMessage());
            return redirect()->back()->with(['error' => __('general.something_wrong')]);
        }
    }
}
