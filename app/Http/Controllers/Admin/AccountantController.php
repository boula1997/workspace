<?php

namespace App\Http\Controllers\Admin;

use App\Models\Accountant;
use App\Models\Admin;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\AccountantRequest;
use Exception;

class AccountantController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    private $accountant;
    function __construct(Accountant $accountant)
    {
        $this->middleware('permission:accountant-list|accountant-create|accountant-edit|accountant-delete', ['only' => ['index', 'show']]);
        $this->middleware('permission:accountant-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:accountant-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:accountant-delete', ['only' => ['destroy']]);
        $this->accountant = $accountant;
    }


    public function index()
    {
        try {
            $accountants = $this->accountant->latest()->get();
            return view('admin.crud.accountants.index', compact('accountants'))
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
        return view('admin.crud.accountants.create','employees');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(AccountantRequest $request)
    {
        try {
            $this->accountant->create($request->all());
            return redirect()->route('accountants.index')
                ->with('success', trans('general.created_successfully'));
        } catch (Exception $e) {
            dd($e->getMessage());
            return redirect()->back()->with(['error' => __('general.something_wrong')]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Accountant  $accountant
     * @return \Illuminate\Http\Response
     */
    public function show(Accountant $accountant)
    {
        return view('admin.crud.accountants.show', compact('accountant'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Accountant  $accountant
     * @return \Illuminate\Http\Response
     */
    public function edit(Accountant $accountant)
    {
        $employees=Admin::get();

        //    dd($accountant->title);
        return view('admin.crud.accountants.edit', compact('accountant','employees'));
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\portfolio  $accountant
     * @return \Illuminate\Http\Response
     */
    public function update(AccountantRequest $request, Accountant $accountant)
    {
        try {
            $data = $request->all();
            $accountant->update($data);
            return redirect()->route('accountants.index')
                ->with('success', trans('general.update_successfully'));
        } catch (Exception $e) {
            dd($e->getMessage());
            return redirect()->back()->with(['error' => __('general.something_wrong')]);
        }
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Accountant  $accountant
     * @return \Illuminate\Http\Response
     */
    public function destroy(Accountant $accountant)
    {
        try {
            $accountant->delete();
            return redirect()->route('accountants.index')
                ->with('success', trans('general.deleted_successfully'));
        } catch (Exception $e) {
            dd($e->getMessage());
            return redirect()->back()->with(['error' => __('general.something_wrong')]);
        }
    }
}
