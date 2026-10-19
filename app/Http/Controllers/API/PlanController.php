<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Plan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PlanController extends Controller
{
    private function adminId(): int
    {
        return (int) auth('admin-api')->id();
    }

    private function mine()
    {
        return Plan::where('admin_id', $this->adminId());
    }

    /** All of the admin's plans, current one first, then newest. */
    public function index()
    {
        return response()->json(
            $this->mine()->orderByDesc('is_current')->orderByDesc('id')->get()
        );
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'is_current' => 'sometimes|boolean',
        ]);

        $plan = DB::transaction(function () use ($data, $request) {
            $makeCurrent = $request->boolean('is_current');
            if ($makeCurrent) {
                $this->mine()->update(['is_current' => false]);
            }

            return Plan::create([
                'admin_id' => $this->adminId(),
                'name' => $data['name'],
                'description' => $data['description'] ?? null,
                'is_current' => $makeCurrent,
            ]);
        });

        return response()->json($plan, 201);
    }

    public function update(Request $request, $id)
    {
        $plan = $this->mine()->findOrFail($id);

        $data = $request->validate([
            'name' => 'sometimes|required|string|max:255',
            'description' => 'nullable|string',
        ]);

        $plan->update($data);

        return response()->json($plan);
    }

    /** Flag this plan as the current one; every other plan of the admin is unflagged. */
    public function setCurrent($id)
    {
        $plan = $this->mine()->findOrFail($id);

        DB::transaction(function () use ($plan) {
            $this->mine()->where('id', '!=', $plan->id)->update(['is_current' => false]);
            $plan->update(['is_current' => true]);
        });

        return response()->json($plan->fresh());
    }

    public function destroy($id)
    {
        $this->mine()->findOrFail($id)->delete();

        return response()->json(null, 204);
    }
}
