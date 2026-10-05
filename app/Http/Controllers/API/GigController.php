<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\phoneGig;
use App\Models\postGig;
use App\Services\GigService;
use Exception;
use Illuminate\Http\Request;

class GigController extends Controller
{
    protected $gigService;

    public function __construct(GigService $gigService)
    {
        $this->gigService = $gigService;
    }

    // ─────────────────────────────────────────────
    //  Phone Gigs
    // ─────────────────────────────────────────────

    /**
     * POST /add/phone/gig
     */
    public function addPhoneGig(Request $request)
    {
        try {
            $request->validate([
                'phone'       => 'required',
                'description' => 'required',
                'type'        => 'required',
            ]);

            if ($this->gigService->phoneGigExists($request->phone)) {
                return failedResponse('phone is founded');
            }

            $phoneGig = $this->gigService->createPhoneGig($request->all());
            return successResponse($phoneGig);
        } catch (Exception $e) {
            return failedResponse($e->getMessage());
        }
    }

    /**
     * GET /get/all/phone/gigs
     */
    public function getAllPhoneGigs(Request $request)
    {
        try {
            $gigs = $this->gigService->getPaginatedPhoneGigs($request->per_page ?? 15, auth('admin-api')->id());
            return successResponse($gigs);
        } catch (Exception $e) {
            return failedResponse($e->getMessage());
        }
    }

    /**
     * DELETE /phone-gig/{id}
     */
    public function deletePhoneGig($id)
    {
        try {
            $this->gigService->deletePhoneGig($id);
            return successResponse([]);
        } catch (Exception $e) {
            return failedResponse($e->getMessage());
        }
    }

    /**
     * POST /add/call/history
     */
    public function addCallHistory(Request $request)
    {
        try {
            $request->validate([
                'phone_gig_id' => 'required|exists:phone_gigs,id',
            ]);

            $callHistory = $this->gigService->createCallHistory($request->phone_gig_id, auth('admin-api')->id());
            return successResponse($callHistory);
        } catch (Exception $e) {
            return failedResponse($e->getMessage());
        }
    }

    /**
     * GET /phone-gig/{id}/history-stats
     * Per-user history counts for one phone gig (logged in user separately, others by count).
     */
    public function phoneGigHistoryStats($id)
    {
        try {
            phoneGig::findOrFail($id);
            return successResponse($this->gigService->phoneGigHistoryStats((int) $id, auth('admin-api')->id()));
        } catch (Exception $e) {
            return failedResponse($e->getMessage());
        }
    }

    /**
     * GET /post-gig/{id}/history-stats
     */
    public function postGigHistoryStats($id)
    {
        try {
            postGig::findOrFail($id);
            return successResponse($this->gigService->postGigHistoryStats((int) $id, auth('admin-api')->id()));
        } catch (Exception $e) {
            return failedResponse($e->getMessage());
        }
    }

    // ─────────────────────────────────────────────
    //  Post Gigs
    // ─────────────────────────────────────────────

    /**
     * POST /add/post/gig
     */
    public function addPostGig(Request $request)
    {
        try {
            $request->validate([
                'post_link'   => 'required',
                'description' => 'required',
                'type'        => 'required',
            ]);

            $postGig = $this->gigService->createPostGig($request->all());
            return successResponse($postGig);
        } catch (Exception $e) {
            return failedResponse($e->getMessage());
        }
    }

    /**
     * GET /get/all/post/gigs
     */
    public function getAllPostGigs(Request $request)
    {
        try {
            $gigs = $this->gigService->getPaginatedPostGigs($request->per_page ?? 15, auth('admin-api')->id());
            return successResponse($gigs);
        } catch (Exception $e) {
            return failedResponse($e->getMessage());
        }
    }

    /**
     * DELETE /post-gig/{id}
     */
    public function deletePostGig($id)
    {
        try {
            $this->gigService->deletePostGig($id);
            return successResponse([]);
        } catch (Exception $e) {
            return failedResponse($e->getMessage());
        }
    }

    /**
     * POST /add/link/history
     */
    public function addLinkHistory(Request $request)
    {
        try {
            $request->validate([
                'post_gig_id' => 'required|exists:post_gigs,id',
            ]);

            $linkHistory = $this->gigService->createLinkHistory($request->post_gig_id, auth('admin-api')->id());
            return successResponse($linkHistory);
        } catch (Exception $e) {
            return failedResponse($e->getMessage());
        }
    }
}
