<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\NoteRequest;
use App\Models\Note;
use DB;
use Hash;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\File;
use App\Models\File as ModelsFile;
use Exception;

class NoteController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    private $note;
    function __construct(Note $note)
    {
        $this->middleware('permission:note-list|note-create|note-edit|note-delete', ['only' => ['index', 'show']]);
        $this->middleware('permission:note-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:note-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:note-delete', ['only' => ['destroy']]);
        $this->note = $note;
    }

    public function index(Request $request)
    {
        try {
            $data = Note::orderBy('id', 'DESC')->get();
            return view('admin.crud.notes.index', compact('data'))
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
        return view('admin.crud.notes.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(NoteRequest $request)
    {

        try {
            $input = $request->all();
            $input['isNotification']=$request->has('isNotification')?1:0;
            $note = Note::create($input);
            return redirect()->route('notes.index')
                ->with('success', 'Note created successfully');
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
        $note = Note::find($id);
        return view('admin.crud.notes.show', compact('note'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $note = Note::find($id);

        return view('admin.crud.notes.edit', compact('note'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(NoteRequest $request, $id)
    {
        try {
            $input = $request->except('image','profile_avatar_remove');
            $input['isNotification']=$request->has('isNotification')?1:0;
            $note = Note::find($id);
            $note->update($input);
            return redirect()->route('notes.index')
                ->with('success', 'Note updated successfully');
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
            $note = Note::find($id);
            $note->delete();
            return redirect()->route('notes.index')
                ->with('success', 'Note deleted successfully');
        } catch (Exception $e) {
            dd($e->getMessage());
            return redirect()->back()->with(['error' => __('general.something_wrong')]);
        }
    }
}
