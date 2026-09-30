<?php

namespace App\Repositories;

use App\Contracts\Repositories\GigRepositoryInterface;
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

    public function paginatePhoneGigs(int $perPage = 15): \Illuminate\Contracts\Pagination\LengthAwarePaginator
    {
        return phoneGig::select('phone_gigs.*')
            ->leftJoin(
                DB::raw('(SELECT phone_gig_id, MAX(created_at) as last_called_at FROM call_histories GROUP BY phone_gig_id) as ch'),
                'phone_gigs.id', '=', 'ch.phone_gig_id'
            )
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

    public function paginatePostGigs(int $perPage = 15): \Illuminate\Contracts\Pagination\LengthAwarePaginator
    {
        return postGig::select('post_gigs.*')
            ->leftJoin(
                DB::raw('(SELECT post_gig_id, MAX(created_at) as last_linked_at FROM link_histories GROUP BY post_gig_id) as lh'),
                'post_gigs.id', '=', 'lh.post_gig_id'
            )
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

    public function createCallHistory(int $phoneGigId): CallHistory
    {
        return CallHistory::create(['phone_gig_id' => $phoneGigId]);
    }

    public function createLinkHistory(int $postGigId): LinkHistory
    {
        return LinkHistory::create(['post_gig_id' => $postGigId]);
    }
}
