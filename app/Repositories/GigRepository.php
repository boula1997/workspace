<?php

namespace App\Repositories;

use App\Contracts\Repositories\GigRepositoryInterface;
use App\Models\Admin;
use App\Models\CallHistory;
use App\Models\LinkHistory;
use App\Models\phoneGig;
use App\Models\postGig;
use Illuminate\Support\Facades\DB;

class GigRepository implements GigRepositoryInterface
{
    // ─────────────────────────────────────────────
    //  Phone Gigs
    // ─────────────────────────────────────────────

    public function createPhoneGig(array $data): phoneGig
    {
        return phoneGig::create($data);
    }

    public function paginatePhoneGigs(int $perPage = 15, ?int $adminId = null): \Illuminate\Contracts\Pagination\LengthAwarePaginator
    {
        // Ordering is per user: a gig drops down the list only for the user who contacted it.
        $lastCalled = DB::table('call_histories')
            ->selectRaw('phone_gig_id, MAX(created_at) as last_called_at')
            ->when($adminId !== null, fn ($q) => $q->where('admin_id', $adminId))
            ->groupBy('phone_gig_id');

        $counts = ['callHistories as histories_count'];
        if ($adminId !== null) {
            $counts['callHistories as my_histories_count'] = fn ($q) => $q->where('admin_id', $adminId);
        }

        return phoneGig::select('phone_gigs.*', 'ch.last_called_at as last_contact')
            ->leftJoinSub($lastCalled, 'ch', 'phone_gigs.id', '=', 'ch.phone_gig_id')
            ->withCount($counts)
            ->orderByRaw('ch.last_called_at IS NOT NULL ASC')
            ->orderByRaw('CASE WHEN ch.last_called_at IS NULL THEN phone_gigs.created_at END DESC')
            ->orderBy('ch.last_called_at', 'ASC')
            ->paginate($perPage);
    }

    public function deletePhoneGig(int $id): phoneGig
    {
        $phoneGig = phoneGig::findOrFail($id);
        $phoneGig->callHistories()->delete();
        $phoneGig->delete();
        return $phoneGig;
    }

    public function phoneGigExists(string $phone): bool
    {
        return phoneGig::where('phone', $phone)->exists();
    }

    // ─────────────────────────────────────────────
    //  Post Gigs
    // ─────────────────────────────────────────────

    public function createPostGig(array $data): postGig
    {
        return postGig::create($data);
    }

    public function paginatePostGigs(int $perPage = 15, ?int $adminId = null): \Illuminate\Contracts\Pagination\LengthAwarePaginator
    {
        $lastLinked = DB::table('link_histories')
            ->selectRaw('post_gig_id, MAX(created_at) as last_linked_at')
            ->when($adminId !== null, fn ($q) => $q->where('admin_id', $adminId))
            ->groupBy('post_gig_id');

        $counts = ['linkHistories as histories_count'];
        if ($adminId !== null) {
            $counts['linkHistories as my_histories_count'] = fn ($q) => $q->where('admin_id', $adminId);
        }

        return postGig::select('post_gigs.*', 'lh.last_linked_at as last_linked_at')
            ->leftJoinSub($lastLinked, 'lh', 'post_gigs.id', '=', 'lh.post_gig_id')
            ->withCount($counts)
            ->orderByRaw('lh.last_linked_at IS NOT NULL ASC')
            ->orderByRaw('CASE WHEN lh.last_linked_at IS NULL THEN post_gigs.created_at END DESC')
            ->orderBy('lh.last_linked_at', 'ASC')
            ->paginate($perPage);
    }

    public function deletePostGig(int $id): postGig
    {
        $postGig = postGig::findOrFail($id);
        $postGig->linkHistories()->delete();
        $postGig->delete();
        return $postGig;
    }

    // ─────────────────────────────────────────────
    //  Histories
    // ─────────────────────────────────────────────

    public function createCallHistory(int $phoneGigId, ?int $adminId = null): CallHistory
    {
        return CallHistory::create(['phone_gig_id' => $phoneGigId, 'admin_id' => $adminId]);
    }

    public function createLinkHistory(int $postGigId, ?int $adminId = null): LinkHistory
    {
        return LinkHistory::create(['post_gig_id' => $postGigId, 'admin_id' => $adminId]);
    }

    // ─────────────────────────────────────────────
    //  Per-user history statistics
    // ─────────────────────────────────────────────

    public function phoneGigHistoryStats(int $phoneGigId, ?int $adminId): array
    {
        return $this->historyStats('call_histories', 'phone_gig_id', $phoneGigId, $adminId);
    }

    public function postGigHistoryStats(int $postGigId, ?int $adminId): array
    {
        return $this->historyStats('link_histories', 'post_gig_id', $postGigId, $adminId);
    }

    /**
     * How many times each user has a history with one gig.
     * Returns the logged in user separately ("me"); everyone else ("others") is ordered by
     * count (desc). Rows recorded before per-user tracking (admin_id NULL) appear as one
     * "Unknown user" entry in "others".
     */
    private function historyStats(string $table, string $gigColumn, int $gigId, ?int $adminId): array
    {
        $rows = DB::table($table)
            ->selectRaw('admin_id, COUNT(*) as cnt, MAX(created_at) as last_at')
            ->where($gigColumn, $gigId)
            ->groupBy('admin_id')
            ->get();

        $names = Admin::whereIn('id', $rows->pluck('admin_id')->filter()->all())->pluck('name', 'id');

        $me = ['admin_id' => $adminId, 'name' => $adminId !== null ? ($names[$adminId] ?? Admin::where('id', $adminId)->value('name')) : null, 'count' => 0, 'last_at' => null];
        $others = [];

        foreach ($rows as $row) {
            if ($adminId !== null && (int) $row->admin_id === $adminId) {
                $me['count'] = (int) $row->cnt;
                $me['last_at'] = $row->last_at;
                continue;
            }
            $others[] = [
                'admin_id' => $row->admin_id !== null ? (int) $row->admin_id : null,
                'name'     => $row->admin_id !== null ? ($names[$row->admin_id] ?? 'User #' . $row->admin_id) : 'Unknown user',
                'count'    => (int) $row->cnt,
                'last_at'  => $row->last_at,
            ];
        }

        usort($others, fn ($a, $b) => ($b['count'] <=> $a['count']) ?: strcmp((string) $a['name'], (string) $b['name']));

        return [
            'total'  => (int) $rows->sum('cnt'),
            'me'     => $me,
            'others' => $others,
        ];
    }
}
