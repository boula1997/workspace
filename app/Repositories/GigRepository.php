<?php

namespace App\Repositories;

use App\Contracts\Repositories\GigRepositoryInterface;
use App\Models\Admin;
use App\Models\CallHistory;
use App\Models\LinkHistory;
use App\Models\phoneGig;
use App\Models\postGig;
use App\Models\saleGig;
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

    // Soft delete: the gig and its contact history stay, so it can be restored.
    // Deleting a gig that is already deleted is not an error.
    public function deletePhoneGig(int $id): phoneGig
    {
        $phoneGig = phoneGig::withTrashed()->findOrFail($id);
        if (!$phoneGig->trashed()) {
            $phoneGig->delete();
        }
        return $phoneGig;
    }

    public function restorePhoneGig(int $id): phoneGig
    {
        $phoneGig = phoneGig::withTrashed()->findOrFail($id);
        if ($phoneGig->trashed()) {
            $phoneGig->restore();
        }
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
        $postGig = postGig::withTrashed()->findOrFail($id);
        if (!$postGig->trashed()) {
            $postGig->delete();
        }
        return $postGig;
    }

    public function restorePostGig(int $id): postGig
    {
        $postGig = postGig::withTrashed()->findOrFail($id);
        if ($postGig->trashed()) {
            $postGig->restore();
        }
        return $postGig;
    }

    // ─────────────────────────────────────────────
    //  Sale Gigs
    // ─────────────────────────────────────────────

    public function createSaleGig(array $data): saleGig
    {
        return saleGig::create($data);
    }

    public function deleteSaleGig(int $id): saleGig
    {
        $saleGig = saleGig::withTrashed()->findOrFail($id);
        if (!$saleGig->trashed()) {
            $saleGig->delete();
        }
        return $saleGig;
    }

    public function restoreSaleGig(int $id): saleGig
    {
        $saleGig = saleGig::withTrashed()->findOrFail($id);
        if ($saleGig->trashed()) {
            $saleGig->restore();
        }
        return $saleGig;
    }

    // ─────────────────────────────────────────────
    //  Gig feed (phone + post + sale gigs together)
    // ─────────────────────────────────────────────

    // Post links by site. LIKE patterns on the lower-cased link.
    private const PLATFORM_PATTERNS = [
        'facebook' => ['%facebook.com%', '%fb.watch%', '%fb.me/%', '%://fb.com%', '%.fb.com%'],
        'linkedin' => ['%linkedin.com%', '%lnkd.in%'],
    ];

    public function paginateGigFeed(array $filters, int $perPage, ?int $adminId): \Illuminate\Contracts\Pagination\LengthAwarePaginator
    {
        // Newest created first. Whether the user already contacted a gig is shown on the card
        // (my_histories_count) and can be filtered with status, it does not change the order.
        return $this->filteredFeed($filters, $adminId)
            ->orderBy('feed.created_at', 'DESC')
            ->orderBy('feed.kind', 'ASC')
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
        $sale = (int) ($byPlatform['sale'] ?? 0);

        return [
            'authors'  => $this->authorFacet($filters, $adminId),
            'all'      => $phone + $facebook + $linkedin + $other + $sale,
            'phone'    => $phone,
            'sale'     => $sale,
            'post'     => $facebook + $linkedin + $other,
            'facebook' => $facebook,
            'linkedin' => $linkedin,
            'other'    => $other,
        ];
    }

    // Who created the gigs under the other filters (not the author filter itself), most gigs
    // first. id is null for gigs created before authors were recorded.
    private function authorFacet(array $filters, ?int $adminId): array
    {
        return $this->filteredFeed(array_diff_key($filters, ['author' => 1]), $adminId)
            ->select(DB::raw('feed.author_id, MAX(feed.author_name) as author_name, COUNT(*) as cnt'))
            ->groupBy('feed.author_id')
            ->orderByDesc('cnt')
            ->get()
            ->map(fn ($row) => [
                'id'    => $row->author_id !== null ? (int) $row->author_id : null,
                'name'  => $row->author_id !== null ? ($row->author_name ?? 'User #' . $row->author_id) : 'Unknown',
                'count' => (int) $row->cnt,
            ])
            ->sortBy(fn ($a) => [-$a['count'], $a['name']])
            ->values()
            ->all();
    }

    private function filteredFeed(array $filters, ?int $adminId): \Illuminate\Database\Query\Builder
    {
        $query = DB::query()->fromSub($this->feedUnion($adminId), 'feed')->select('feed.*');

        // Deleted (soft deleted) gigs are listed only when asked for, and then on their own
        if (!empty($filters['deleted'])) {
            $query->whereNotNull('feed.deleted_at');
        } else {
            $query->whereNull('feed.deleted_at');
        }

        if (!empty($filters['kind'])) {
            $query->where('feed.kind', $filters['kind']);
        }
        if (!empty($filters['platform'])) {
            $query->where('feed.platform', $filters['platform']); // phone gigs have platform 'phone'
        }
        if (!empty($filters['type'])) {
            $query->where('feed.type', $filters['type']);
        }
        if (isset($filters['author']) && $filters['author'] !== '') {
            $filters['author'] === 'none'
                ? $query->whereNull('feed.author_id')
                : $query->where('feed.author_id', (int) $filters['author']);
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

    // All three tables in one shape: kind, id, target (phone, link or sale title), phone, post_link,
    // platform, title (sale gigs only), description, type, last_contact (this user's last contact),
    // histories_count, my_histories_count. Sale gigs have no contact, so no history.
    private function feedUnion(?int $adminId): \Illuminate\Database\Query\Builder
    {
        $text = DB::getDriverName() === 'mysql' ? 'CHAR' : 'VARCHAR';
        $time = DB::getDriverName() === 'mysql' ? 'DATETIME' : 'TIMESTAMP';

        $phones = $this->feedPart('phone_gigs', 'call_histories', 'phone_gig_id', $adminId)
            ->selectRaw("'phone' as kind, g.id, g.phone as target, g.phone, NULL as post_link")
            ->selectRaw("'phone' as platform, CAST(NULL AS $text) as title");
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
            ->selectRaw($platform . ", CAST(NULL AS $text) as title", $bindings);
        $this->addSharedFeedColumns($posts);

        $sales = DB::table('sale_gigs as g')
            ->selectRaw("'sale' as kind, g.id, g.title as target, CAST(NULL AS $text) as phone, CAST(NULL AS $text) as post_link")
            ->selectRaw("'sale' as platform, g.title")
            ->selectRaw("g.description, CAST('sale' AS $text) as type, CAST(NULL AS $time) as last_contact")
            ->selectRaw('0 as histories_count, 0 as my_histories_count')
            ->selectRaw('g.created_at, g.updated_at, g.deleted_at, g.author_id')
            ->selectRaw('(SELECT admins.name FROM admins WHERE admins.id = g.author_id) as author_name');

        return $phones->unionAll($posts)->unionAll($sales);
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
            ->selectRaw('g.created_at, g.updated_at, g.deleted_at, g.author_id')
            ->selectRaw('(SELECT admins.name FROM admins WHERE admins.id = g.author_id) as author_name');
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
