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
    //  Gig feed (phone + post gigs together)
    // ─────────────────────────────────────────────

    // Post links by site. LIKE patterns on the lower-cased link.
    private const PLATFORM_PATTERNS = [
        'facebook' => ['%facebook.com%', '%fb.watch%', '%fb.me/%', '%://fb.com%', '%.fb.com%'],
        'linkedin' => ['%linkedin.com%', '%lnkd.in%'],
    ];

    public function paginateGigFeed(array $filters, int $perPage, ?int $adminId): \Illuminate\Contracts\Pagination\LengthAwarePaginator
    {
        // Same order as the separate lists: gigs this user hasn't contacted yet first (newest
        // first), then the ones they contacted, longest ago first.
        return $this->filteredFeed($filters, $adminId)
            ->orderByRaw('CASE WHEN feed.my_histories_count = 0 THEN 0 ELSE 1 END ASC')
            ->orderByRaw('CASE WHEN feed.my_histories_count = 0 THEN feed.created_at END DESC')
            ->orderBy('feed.last_contact', 'ASC')
            ->orderBy('feed.id', 'DESC')
            ->paginate($perPage);
    }

    // Counts per kind and per platform, with every filter applied except kind and platform
    // themselves (so each chip says how many gigs picking it would show).
    public function gigFeedFacets(array $filters, ?int $adminId): array
    {
        $byPlatform = $this->filteredFeed(array_diff_key($filters, ['kind' => 1, 'platform' => 1]), $adminId)
            ->select(DB::raw('feed.platform, COUNT(*) as cnt'))
            ->groupBy('feed.platform')
            ->pluck('cnt', 'platform');

        $facebook = (int) ($byPlatform['facebook'] ?? 0);
        $linkedin = (int) ($byPlatform['linkedin'] ?? 0);
        $other = (int) ($byPlatform['other'] ?? 0);
        $phone = (int) ($byPlatform['phone'] ?? 0);

        return [
            'all'      => $phone + $facebook + $linkedin + $other,
            'phone'    => $phone,
            'post'     => $facebook + $linkedin + $other,
            'facebook' => $facebook,
            'linkedin' => $linkedin,
            'other'    => $other,
        ];
    }

    private function filteredFeed(array $filters, ?int $adminId): \Illuminate\Database\Query\Builder
    {
        $query = DB::query()->fromSub($this->feedUnion($adminId), 'feed')->select('feed.*');

        if (!empty($filters['kind'])) {
            $query->where('feed.kind', $filters['kind']);
        }
        if (!empty($filters['platform'])) {
            $query->where('feed.platform', $filters['platform']); // phone gigs have platform 'phone'
        }
        if (!empty($filters['type'])) {
            $query->where('feed.type', $filters['type']);
        }
        if (($filters['status'] ?? null) === 'new') {
            $query->where('feed.my_histories_count', 0);
        } elseif (($filters['status'] ?? null) === 'contacted') {
            $query->where('feed.my_histories_count', '>', 0);
        }

        $search = trim((string) ($filters['search'] ?? ''));
        if ($search !== '') {
            $like = '%' . addcslashes(mb_strtolower($search), '%_\\') . '%';
            $digits = preg_replace('/\D/', '', $search);
            $looksLikeNumber = strlen($digits) >= 3 && preg_match('/^[\d\s+()-]+$/', $search);

            $query->where(function ($q) use ($like, $digits, $looksLikeNumber) {
                $q->whereRaw('LOWER(COALESCE(feed.description, \'\')) LIKE ?', [$like])
                    ->orWhereRaw('LOWER(feed.target) LIKE ?', [$like]);
                if ($looksLikeNumber) {
                    // Numbers are saved as +<digits>, so "010 123" still finds +2010123...
                    $q->orWhere(fn ($n) => $n->where('feed.kind', 'phone')->where('feed.target', 'LIKE', '%' . $digits . '%'));
                }
            });
        }

        return $query;
    }

    // Both tables in one shape: kind, id, target (phone or link), phone, post_link, description,
    // type, platform, last_contact (this user's last contact), histories_count, my_histories_count.
    private function feedUnion(?int $adminId): \Illuminate\Database\Query\Builder
    {
        $phones = $this->feedPart('phone_gigs', 'call_histories', 'phone_gig_id', $adminId)
            ->selectRaw("'phone' as kind, g.id, g.phone as target, g.phone, NULL as post_link")
            ->selectRaw("'phone' as platform");
        $this->addSharedFeedColumns($phones);

        $platform = 'CASE';
        $bindings = [];
        foreach (self::PLATFORM_PATTERNS as $name => $patterns) {
            $platform .= ' WHEN ' . implode(' OR ', array_fill(0, count($patterns), 'LOWER(g.post_link) LIKE ?')) . " THEN '$name'";
            array_push($bindings, ...$patterns);
        }
        $platform .= " ELSE 'other' END as platform";

        $posts = $this->feedPart('post_gigs', 'link_histories', 'post_gig_id', $adminId)
            ->selectRaw("'post' as kind, g.id, g.post_link as target, NULL as phone, g.post_link")
            ->selectRaw($platform, $bindings);
        $this->addSharedFeedColumns($posts);

        return $phones->unionAll($posts);
    }

    private function feedPart(string $table, string $historyTable, string $gigColumn, ?int $adminId): \Illuminate\Database\Query\Builder
    {
        $all = DB::table($historyTable)
            ->selectRaw("$gigColumn as gig_id, COUNT(*) as cnt")
            ->groupBy($gigColumn);

        $mine = DB::table($historyTable)
            ->selectRaw("$gigColumn as gig_id, COUNT(*) as cnt, MAX(created_at) as last_at")
            ->where('admin_id', $adminId ?? 0)
            ->groupBy($gigColumn);

        return DB::table("$table as g")
            ->leftJoinSub($all, 'allh', 'allh.gig_id', '=', 'g.id')
            ->leftJoinSub($mine, 'mine', 'mine.gig_id', '=', 'g.id');
    }

    // Columns both tables have. A UNION matches columns by position, so these go last on both parts.
    private function addSharedFeedColumns(\Illuminate\Database\Query\Builder $query): void
    {
        // `type` is a separate enum per table on Postgres, which a UNION can't merge: cast to text
        $text = DB::getDriverName() === 'mysql' ? 'CHAR' : 'VARCHAR';
        $query->selectRaw("g.description, CAST(g.type AS $text) as type, mine.last_at as last_contact")
            ->selectRaw('COALESCE(allh.cnt, 0) as histories_count, COALESCE(mine.cnt, 0) as my_histories_count')
            ->selectRaw('g.created_at, g.updated_at');
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
