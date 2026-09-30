<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\phoneGig;
use App\Models\postGig;
use App\Models\CallHistory;
use App\Models\LinkHistory;
use App\Http\Resources\PhoneGigResource;
use App\Http\Resources\PostGigResource;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class GigController extends Controller
{
    // ─────────────────────────────────────────────
    //  Phone Gigs
    // ─────────────────────────────────────────────

    /**
     * POST /add/phone/gig
     * Creates a new phone gig entry after validating uniqueness.
     */
    public function addPhoneGig(Request $request)
    {
        $validator = validator($request->all(), [
            'phone'       => 'required|string|unique:phone_gigs,phone',
            'description' => 'nullable|string',
            'type'        => 'required|string|in:job,freelance',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status'  => 422,
                'success' => false,
                'message' => $validator->errors()->first(),
                'errors'  => $validator->errors(),
            ], 422);
        }

        $phoneGig = phoneGig::create([
            'phone'       => $request->phone,
            'description' => $request->description ?? '',
            'type'        => $request->type,
        ]);

        return successResponse($phoneGig);
    }

    /**
     * GET /get/all/phone/gigs
     * Returns paginated phone gigs ordered by call recency (never-called first).
     */
    public function getAllPhoneGigs(Request $request)
    {
        $perPage = $request->get('per_page', 15);

        $phoneGigs = phoneGig::select('phone_gigs.*')
            ->leftJoin(
                DB::raw('(SELECT phone_gig_id, MAX(created_at) as last_called_at FROM call_histories GROUP BY phone_gig_id) as ch'),
                'phone_gigs.id', '=', 'ch.phone_gig_id'
            )
            ->orderByRaw('ch.last_called_at IS NOT NULL ASC')
            ->orderByRaw('CASE WHEN ch.last_called_at IS NULL THEN phone_gigs.created_at END DESC')
            ->orderBy('ch.last_called_at', 'ASC')
            ->paginate($perPage);

        return successResponse($phoneGigs);
    }

    /**
     * DELETE /phone-gig/{id}
     * Deletes a phone gig and its associated call histories.
     */
    public function deletePhoneGig($id)
    {
        $phoneGig = phoneGig::findOrFail($id);
        $phoneGig->callHistories()->delete();
        $phoneGig->delete();

        return successResponse($phoneGig);
    }

    // ─────────────────────────────────────────────
    //  Post Gigs
    // ─────────────────────────────────────────────

    /**
     * POST /add/post/gig
     * Creates a new post gig entry.
     */
    public function addPostGig(Request $request)
    {
        $request->validate([
            'post_link'   => 'required|string',
            'description' => 'required|string',
            'type'        => 'required|string',
        ]);

        $postGig = postGig::create([
            'post_link'   => $request->post_link,
            'description' => $request->description,
            'type'        => $request->type,
        ]);

        return successResponse($postGig);
    }

    /**
     * GET /get/all/post/gigs
     * Returns paginated post gigs ordered by link recency (never-linked first).
     */
    public function getAllPostGigs(Request $request)
    {
        $perPage = $request->get('per_page', 15);

        $postGigs = postGig::select('post_gigs.*')
            ->leftJoin(
                DB::raw('(SELECT post_gig_id, MAX(created_at) as last_linked_at FROM link_histories GROUP BY post_gig_id) as lh'),
                'post_gigs.id', '=', 'lh.post_gig_id'
            )
            ->orderByRaw('lh.last_linked_at IS NOT NULL ASC')
            ->orderByRaw('CASE WHEN lh.last_linked_at IS NULL THEN post_gigs.created_at END DESC')
            ->orderBy('lh.last_linked_at', 'ASC')
            ->paginate($perPage);

        return successResponse($postGigs);
    }

    /**
     * DELETE /post-gig/{id}
     * Deletes a post gig and its associated link histories.
     */
    public function deletePostGig($id)
    {
        $postGig = postGig::findOrFail($id);
        $postGig->linkHistories()->delete();
        $postGig->delete();

        return successResponse($postGig);
    }

    // ─────────────────────────────────────────────
    //  Call & Link Histories
    // ─────────────────────────────────────────────

    /**
     * POST /add/call/history
     * Records a call history entry for a phone gig.
     */
    public function addCallHistory(Request $request)
    {
        $request->validate([
            'phone_gig_id' => 'required|exists:phone_gigs,id',
        ]);

        $callHistory = CallHistory::create([
            'phone_gig_id' => $request->phone_gig_id,
        ]);

        return successResponse($callHistory);
    }

    /**
     * POST /add/link/history
     * Records a link history entry for a post gig.
     */
    public function addLinkHistory(Request $request)
    {
        $request->validate([
            'post_gig_id' => 'required|exists:post_gigs,id',
        ]);

        $linkHistory = LinkHistory::create([
            'post_gig_id' => $request->post_gig_id,
        ]);

        return successResponse($linkHistory);
    }
}
