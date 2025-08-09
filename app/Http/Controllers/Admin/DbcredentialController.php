<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\DbcredentialRequest;
use App\Models\DBCredential;
use DB;
use Hash;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\File;
use App\Models\File as ModelsFile;
use Exception;

class DbcredentialController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    private $dbcredential;
    function __construct(DBCredential $dbcredential)
    {
        $this->middleware('permission:dbcredential-list|dbcredential-create|dbcredential-edit|dbcredential-delete', ['only' => ['index', 'show']]);
        $this->middleware('permission:dbcredential-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:dbcredential-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:dbcredential-delete', ['only' => ['destroy']]);
        $this->dbcredential = $dbcredential;
    }

    public function index(Request $request)
    {
        try {
            $data = DBCredential::orderBy('id', 'DESC')->paginate(5);
            return view('admin.crud.dbcredentials.index', compact('data'))
                ->with('i', ($request->input('page', 1) - 1) * 5);
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
        return view('admin.crud.dbcredentials.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(DbcredentialRequest $request)
    {

        try {
            $input = $request->all();
            $input['password'] = Hash::make($input['password']);
            $dbcredential = DBCredential::create($input);
            return redirect()->route('dbcredentials.index')
                ->with('success', 'Dbcredential created successfully');
        } catch (Exception $e) {
            dd($e->getMessage());
            return redirect()->back()->with(['error' => __('general.something_wrong')]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $dbcredential = DBCredential::find($id);
        return view('admin.crud.dbcredentials.show', compact('dbcredential'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $dbcredential = DBCredential::find($id);

        return view('admin.crud.dbcredentials.edit', compact('dbcredential'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(DbcredentialRequest $request, $id)
    {
        try {
            $input = $request->except('image','profile_avatar_remove');
            if (!empty($input['password'])) {
                $input['password'] = Hash::make($input['password']);
            } else {
                $input = Arr::except($input, array('password'));
            }
            $dbcredential = DBCredential::find($id);
            $dbcredential->update($input);
            return redirect()->route('dbcredentials.index')
                ->with('success', 'Dbcredential updated successfully');
        } catch (Exception $e) {
            dd($e->getMessage());
            return redirect()->back()->with(['error' => __('general.something_wrong')]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $dbcredential = DBCredential::find($id);
            $dbcredential->delete();
            return redirect()->route('dbcredentials.index')
                ->with('success', 'Dbcredential deleted successfully');
        } catch (Exception $e) {
            dd($e->getMessage());
            return redirect()->back()->with(['error' => __('general.something_wrong')]);
        }
    }
}
