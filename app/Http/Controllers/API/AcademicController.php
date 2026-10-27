<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Academic;
use App\Models\AcademicItem;
use Illuminate\Http\Request;

// Study topics and their question/answer items. Everything is scoped to the signed-in admin.
class AcademicController extends Controller
{
    private function mine()
    {
        return Academic::where('admin_id', (int) auth('admin-api')->id());
    }

    // Items are owned through their topic, so they are only reachable via the admin's own topics
    private function myItem($id)
    {
        return AcademicItem::whereIn('academic_id', $this->mine()->select('id'))->findOrFail($id);
    }

    // Topics only, with how many items each has; the items themselves are paged by items()
    public function index()
    {
        return response()->json($this->mine()->withCount('items')->orderBy('title')->get());
    }

    public function items(Request $request, $id)
    {
        $perPage = min(max((int) $request->query('per_page', 20), 1), 100);

        return response()->json($this->mine()->findOrFail($id)->items()->paginate($perPage));
    }

    public function store(Request $request)
    {
        $data = $request->validate(['title' => 'required|string|max:255']);

        $academic = Academic::create($data + ['admin_id' => (int) auth('admin-api')->id()]);

        return response()->json($academic->loadCount('items'), 201);
    }

    public function update(Request $request, $id)
    {
        $academic = $this->mine()->findOrFail($id);
        $academic->update($request->validate(['title' => 'required|string|max:255']));

        return response()->json($academic->loadCount('items'));
    }

    public function destroy($id)
    {
        $this->mine()->findOrFail($id)->delete();

        return response()->json(null, 204);
    }

    public function storeItem(Request $request, $id)
    {
        $academic = $this->mine()->findOrFail($id);

        $data = $request->validate([
            'question' => 'required|string',
            'answer' => 'required|string',
        ]);

        return response()->json($academic->items()->create($data), 201);
    }

    public function updateItem(Request $request, $id)
    {
        $item = $this->myItem($id);

        $item->update($request->validate([
            'question' => 'required|string',
            'answer' => 'required|string',
        ]));

        return response()->json($item);
    }

    public function destroyItem($id)
    {
        $this->myItem($id)->delete();

        return response()->json(null, 204);
    }
}
