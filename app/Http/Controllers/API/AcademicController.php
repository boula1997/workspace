<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Academic;
use App\Models\AcademicItem;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;

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

    // Topics only, with how many items each has (and how many of those are hidden);
    // the items themselves are paged by items()
    public function index()
    {
        return response()->json(
            $this->mine()->withCount(['items', 'items as hidden_count' => fn ($q) => $q->where('is_hidden', true)])
                ->orderBy('title')->get()
        );
    }

    /**
     * GET /academics/{id}/items - one page of a topic's items.
     * Filters: search (question or answer, case-insensitive), hidden (0 = visible only, the
     * default; 1 = hidden only; all). With random=1 the order is shuffled but fixed by `seed`,
     * so the pages of one shuffle never repeat or skip an item.
     * Each item carries its multiple choice `options` (id, option_text, is_correct), empty when it has none.
     */
    public function items(Request $request, $id)
    {
        $filters = $request->validate([
            'search' => 'nullable|string|max:200',
            'hidden' => 'nullable|in:0,1,all',
            'random' => 'nullable|boolean',
            'seed' => 'nullable|integer',
            'page' => 'nullable|integer|min:1',
            'per_page' => 'nullable|integer|min:1|max:100',
        ]);

        $perPage = (int) ($filters['per_page'] ?? 20);
        $page = (int) ($filters['page'] ?? 1);
        $hidden = $filters['hidden'] ?? '0';

        $query = $this->mine()->findOrFail($id)->items();

        if ($hidden !== 'all') {
            $query->where('is_hidden', $hidden === '1');
        }

        if (filled($filters['search'] ?? null)) {
            // LOWER on both sides: LIKE is case-insensitive on MySQL but not on PostgreSQL
            $term = '%' . addcslashes(mb_strtolower($filters['search']), '%_\\') . '%';
            $query->where(fn ($q) => $q->whereRaw('LOWER(question) LIKE ?', [$term])
                ->orWhereRaw('LOWER(answer) LIKE ?', [$term]));
        }

        if (! ($filters['random'] ?? false)) {
            return response()->json($query->with('options')->paginate($perPage));
        }

        // Shuffle only the ids (small), then load just the rows of the requested page
        $seed = (int) ($filters['seed'] ?? 0);
        $ids = $query->reorder()->pluck('id')->sortBy(fn ($itemId) => crc32($seed . ':' . $itemId))->values();
        $pageIds = $ids->forPage($page, $perPage);
        $rows = AcademicItem::with('options')->whereIn('id', $pageIds)->get()->keyBy('id');

        return response()->json(new LengthAwarePaginator(
            $pageIds->map(fn ($itemId) => $rows->get($itemId))->filter()->values(),
            $ids->count(),
            $perPage,
            $page
        ));
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

        // The edit form sends question and answer; hiding/showing sends only is_hidden
        $item->update($request->validate([
            'question' => 'sometimes|required|string',
            'answer' => 'sometimes|required|string',
            'is_hidden' => 'sometimes|boolean',
        ]));

        return response()->json($item);
    }

    public function destroyItem($id)
    {
        $this->myItem($id)->delete();

        return response()->json(null, 204);
    }
}
