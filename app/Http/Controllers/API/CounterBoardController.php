<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\CounterCategory;
use App\Models\CounterHistory;
use App\Models\CounterItem;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

/**
 * The app's Counters tab. The app works from a copy on the device (it must work offline and while
 * the app is locked) and sends its changes here as a list of operations; every operation is safe to
 * send twice, so a sync that was cut off can simply be sent again.
 */
class CounterBoardController extends Controller
{
    private const OP_TYPES = [
        'category.upsert', 'category.delete',
        'item.upsert', 'item.count', 'item.note', 'item.hidden', 'item.delete',
    ];

    /**
     * GET /counters
     * Everything the signed-in admin has: categories, items and their history (newest first).
     */
    public function index()
    {
        try {
            return successResponse($this->state(auth('admin-api')->id()));
        } catch (Exception $e) {
            return failedResponse($e->getMessage());
        }
    }

    /**
     * POST /counters/sync
     * Applies the device's queued operations in order, then returns the full state.
     *
     * Operations (all keyed by uuids made on the device):
     *  category.upsert {uuid, name}                 create or rename a category
     *  category.delete {uuid}                       with its items and their history
     *  item.upsert     {uuid, category_uuid, title} create or rename an item
     *  item.count      {op_uuid, uuid, value, at}   set the count (history: old -> new)
     *  item.note       {op_uuid, uuid, value, at}   set the note, null clears it (history: old -> new)
     *  item.hidden     {uuid, hidden}               hide / show an item
     *  item.delete     {uuid}                       with its history
     */
    public function sync(Request $request)
    {
        try {
            $request->validate([
                'ops'                 => 'present|array|max:1000',
                'ops.*.type'          => 'required|string|in:' . implode(',', self::OP_TYPES),
                'ops.*.uuid'          => 'required|string|max:64',
                'ops.*.op_uuid'       => 'nullable|string|max:64',
                'ops.*.category_uuid' => 'nullable|string|max:64',
                'ops.*.name'          => 'nullable|string|max:255',
                'ops.*.title'         => 'nullable|string|max:255',
                'ops.*.at'            => 'nullable|date',
            ]);

            $adminId = auth('admin-api')->id();

            DB::transaction(function () use ($request, $adminId) {
                foreach ($request->input('ops', []) as $op) {
                    $this->apply($adminId, $op);
                }
            });

            return successResponse($this->state($adminId));
        } catch (ValidationException $e) {
            return failedResponse($e->validator->errors()->first());
        } catch (Exception $e) {
            return failedResponse($e->getMessage());
        }
    }

    private function apply(int $adminId, array $op): void
    {
        $uuid = $op['uuid'];

        switch ($op['type']) {
            case 'category.upsert':
                $name = trim((string) ($op['name'] ?? ''));
                if ($name === '') return;
                CounterCategory::updateOrCreate(['admin_id' => $adminId, 'uuid' => $uuid], ['name' => $name]);
                return;

            case 'category.delete':
                $itemUuids = CounterItem::where('admin_id', $adminId)->where('category_uuid', $uuid)->pluck('uuid');
                CounterHistory::where('admin_id', $adminId)->whereIn('item_uuid', $itemUuids)->delete();
                CounterItem::where('admin_id', $adminId)->where('category_uuid', $uuid)->delete();
                CounterCategory::where('admin_id', $adminId)->where('uuid', $uuid)->delete();
                return;

            case 'item.upsert':
                $title = trim((string) ($op['title'] ?? ''));
                $categoryUuid = $op['category_uuid'] ?? null;
                if ($title === '' || !$categoryUuid) return;
                // The category was deleted (maybe on another device): drop the item too
                if (!CounterCategory::where('admin_id', $adminId)->where('uuid', $categoryUuid)->exists()) return;
                CounterItem::updateOrCreate(
                    ['admin_id' => $adminId, 'uuid' => $uuid],
                    ['category_uuid' => $categoryUuid, 'title' => $title]
                );
                return;

            case 'item.count':
            case 'item.note':
                $this->applyValueChange($adminId, $op, $op['type'] === 'item.count' ? 'count' : 'note');
                return;

            case 'item.hidden':
                CounterItem::where('admin_id', $adminId)->where('uuid', $uuid)
                    ->update(['is_hidden' => (bool) ($op['hidden'] ?? false)]);
                return;

            case 'item.delete':
                CounterHistory::where('admin_id', $adminId)->where('item_uuid', $uuid)->delete();
                CounterItem::where('admin_id', $adminId)->where('uuid', $uuid)->delete();
                return;
        }
    }

    // A count / note change: applied once (op_uuid), and recorded in the history as "what it was ->
    // what it became", with the old value taken from the server so the history chain stays exact.
    private function applyValueChange(int $adminId, array $op, string $field): void
    {
        $opUuid = $op['op_uuid'] ?? null;
        if (!$opUuid || CounterHistory::where('op_uuid', $opUuid)->exists()) return;

        $item = CounterItem::where('admin_id', $adminId)->where('uuid', $op['uuid'])->first();
        if (!$item) return;

        if ($field === 'count') {
            $new = (int) ($op['value'] ?? 0);
            $old = $item->count;
        } else {
            $value = $op['value'] ?? null;
            $new = ($value === null || trim((string) $value) === '') ? null : (string) $value;
            $old = $item->note;
        }
        if ($old === $new) return;

        $item->update([$field => $new]);

        CounterHistory::create([
            'admin_id'   => $adminId,
            'op_uuid'    => $opUuid,
            'item_uuid'  => $item->uuid,
            'field'      => $field,
            'old_value'  => $old === null ? null : (string) $old,
            'new_value'  => $new === null ? null : (string) $new,
            // Stored in the app timezone, like created_at, so it serializes back to the same instant
            'changed_at' => !empty($op['at']) ? Carbon::parse($op['at'])->setTimezone(config('app.timezone')) : now(),
        ]);
    }

    private function state(int $adminId): array
    {
        return [
            'categories' => CounterCategory::where('admin_id', $adminId)->orderBy('id')->get(['uuid', 'name']),
            'items'      => CounterItem::where('admin_id', $adminId)->orderBy('id')
                ->get(['uuid', 'category_uuid', 'title', 'count', 'note', 'is_hidden', 'updated_at']),
            'histories'  => CounterHistory::where('admin_id', $adminId)
                ->orderByDesc('changed_at')->orderByDesc('id')
                ->get(['op_uuid', 'item_uuid', 'field', 'old_value', 'new_value', 'changed_at']),
        ];
    }
}
