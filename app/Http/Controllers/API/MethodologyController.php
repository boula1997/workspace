<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Methodology;
use Illuminate\Http\Request;

/**
 * A methodology is a titled description of how to approach something. It is not tied to a database
 * credential: the SQL tab shows the same list for all of them.
 */
class MethodologyController extends Controller
{
    public function index(Request $request)
    {
        $query = Methodology::query();

        if ($request->filled('search')) {
            $search = $request->query('search');
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', '%' . $search . '%')
                    ->orWhere('description', 'like', '%' . $search . '%');
            });
        }

        return response()->json(
            $query->orderByDesc('id')->paginate($request->integer('per_page', 50))
        );
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
        ]);

        return response()->json(Methodology::create($data), 201);
    }

    public function show($id)
    {
        return response()->json(Methodology::findOrFail($id));
    }

    public function update(Request $request, $id)
    {
        $methodology = Methodology::findOrFail($id);

        $data = $request->validate([
            'title' => 'sometimes|required|string|max:255',
            'description' => 'sometimes|required|string',
        ]);

        $methodology->update($data);

        return response()->json($methodology);
    }

    public function destroy($id)
    {
        Methodology::findOrFail($id)->delete();

        return response()->json(null, 204);
    }
}
