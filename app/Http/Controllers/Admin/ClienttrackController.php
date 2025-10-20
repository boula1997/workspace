<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\ClienttrackRequest;
use App\Models\Clienttrack;
use DB;
use Hash;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\File;
use App\Models\File as ModelsFile;
use Exception;

class ClienttrackController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    private $clienttrack;
    function __construct(Clienttrack $clienttrack)
    {
        $this->middleware('permission:clienttrack-list|clienttrack-create|clienttrack-edit|clienttrack-delete', ['only' => ['index', 'show']]);
        $this->middleware('permission:clienttrack-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:clienttrack-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:clienttrack-delete', ['only' => ['destroy']]);
        $this->clienttrack = $clienttrack;
    }

    public function index(Request $request)
    {
        try {
            $data = Clienttrack::orderBy('id', 'DESC')->get();
            return view('admin.crud.clienttracks.index', compact('data'));
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
        return view('admin.crud.clienttracks.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ClienttrackRequest $request)
    {

        try {
            $input = $request->all();
            $input['password'] = Hash::make($input['password']);
            $clienttrack = Clienttrack::create($input);
            $clienttrack->uploadFile();
            return redirect()->route('clienttracks.index')
                ->with('success', 'Clienttrack created successfully');
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
        $clienttrack = Clienttrack::find($id);
        return view('admin.crud.clienttracks.show', compact('clienttrack'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $clienttrack = Clienttrack::find($id);

        return view('admin.crud.clienttracks.edit', compact('clienttrack'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ClienttrackRequest $request, $id)
    {
        try {
            $input = $request->except('image','profile_avatar_remove');
            if (!empty($input['password'])) {
                $input['password'] = Hash::make($input['password']);
            } else {
                $input = Arr::except($input, array('password'));
            }
            $clienttrack = Clienttrack::find($id);
            $clienttrack->update($input);
            $clienttrack->updateFile();
            return redirect()->route('clienttracks.index')
                ->with('success', 'Clienttrack updated successfully');
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
            $clienttrack = Clienttrack::find($id);
            $clienttrack->delete();
            $clienttrack->deleteFile();
            return redirect()->route('clienttracks.index')
                ->with('success', 'Clienttrack deleted successfully');
        } catch (Exception $e) {
            dd($e->getMessage());
            return redirect()->back()->with(['error' => __('general.something_wrong')]);
        }
    }
}
