<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Learning;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class LearningController extends Controller
{
    private function mine()
    {
        return Learning::where('admin_id', (int) auth('admin-api')->id());
    }

    public function index()
    {
        return response()->json($this->mine()->orderByDesc('id')->get());
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'notes' => 'nullable|string',
            'status' => ['sometimes', Rule::in(Learning::STATUSES)],
        ]);

        $learning = Learning::create($data + ['admin_id' => (int) auth('admin-api')->id()]);

        return response()->json($learning->fresh(), 201);
    }

    public function update(Request $request, $id)
    {
        $learning = $this->mine()->findOrFail($id);

        $data = $request->validate([
            'title' => 'sometimes|required|string|max:255',
            'notes' => 'nullable|string',
            'status' => ['sometimes', Rule::in(Learning::STATUSES)],
        ]);

        $learning->update($data);

        return response()->json($learning);
    }

    public function destroy($id)
    {
        $this->mine()->findOrFail($id)->delete();

        return response()->json(null, 204);
    }
}
