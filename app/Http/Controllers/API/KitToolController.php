<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\KitTool;
use Illuminate\Http\Request;

class KitToolController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
public function index(Request $request)
{
    $query = KitTool::query();

    if ($request->has('is_public')) {
    $query->where('isPublic', $request->boolean('is_public'));
}

    if ($request->filled('d_b_credential_id')) {
        $query->where('d_b_credential_id', $request->query('d_b_credential_id'));
    }

    if ($request->filled('search')) {
        $query->where('title', 'like', '%' . $request->query('search') . '%');
    }

    return response()->json(
        $query->orderByDesc('id')->paginate($request->integer('per_page', 7))
    );
}

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
public function store(Request $request)
{
    $validated = $request->validate([
        'title' => 'required|string|max:255',
        'd_b_credential_id' => 'required|integer',
        'content' => 'nullable|string',
        'isPublic' => 'sometimes|boolean',
    ]);

    $kitTool = KitTool::create($validated);

    return response()->json($kitTool, 201);
}

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $kitTool = KitTool::findOrFail($id);
        return response()->json($kitTool);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
public function update(Request $request, $id)
{
    $kitTool = KitTool::findOrFail($id);

    $validated = $request->validate([
        'title' => 'sometimes|required|string|max:255',
        'd_b_credential_id' => 'sometimes|required|integer',
        'content' => 'nullable|string',
        'isPublic' => 'sometimes|boolean',
    ]);

    $kitTool->update($validated);

    return response()->json($kitTool);
}

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $kitTool = KitTool::findOrFail($id);
        $kitTool->delete();

        return response()->json(null, 204);
    }
}
