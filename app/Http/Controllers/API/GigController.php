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

    /**
     * GET /gigs
     * Phone and post gigs in one feed, for the app's Gigs tab. All filters run here:
     * kind (phone|post), type (job|freelance), status (new|contacted, by the logged in user),
     * platform (facebook|linkedin|other, posts only), search (number, link or description) and
     * deleted (1 = only soft deleted gigs, otherwise only live ones) and author (an admin id, or
     * "none" for gigs created before authors were recorded).
     * The response is a normal page plus `facets`: how many gigs each kind/platform has under
     * the other filters, for the filter chips.
     */
    public function getGigFeed(Request $request)
    {
        try {
            $filters = $request->validate([
                'kind'     => 'nullable|in:phone,post',
                'type'     => 'nullable|in:job,freelance',
                'status'   => 'nullable|in:new,contacted',
                'platform' => 'nullable|in:facebook,linkedin,other',
                'deleted'  => 'nullable|boolean',
                // array syntax: the "|" inside the regex would otherwise split the rule
                'author'   => ['nullable', 'string', 'regex:/^(\d+|none)$/'],
                'search'   => 'nullable|string|max:200',
                'per_page' => 'nullable|integer|min:1|max:100',
            ]);

            $feed = $this->gigService->getGigFeed($filters, (int) ($filters['per_page'] ?? 20), auth('admin-api')->id());
            return successResponse($feed);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return failedResponse($e->validator->errors()->first());
        } catch (Exception $e) {
            return failedResponse($e->getMessage());
        }
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

            // Only the form's fields; the author is always the signed-in admin, never client supplied
            $phoneGig = $this->gigService->createPhoneGig(
                $request->only(['phone', 'description', 'type']) + ['author_id' => auth('admin-api')->id()]
            );
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
            $this->gigService->deletePhoneGig((int) $id);
            return successResponse([]);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return failedResponse('This gig no longer exists.');
        } catch (Exception $e) {
            return failedResponse($e->getMessage());
        }
    }

    /**
     * POST /phone-gig/{id}/restore
     */
    public function restorePhoneGig($id)
    {
        try {
            return successResponse($this->gigService->restorePhoneGig((int) $id));
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return failedResponse('This gig no longer exists.');
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
            phoneGig::withTrashed()->findOrFail($id);
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
            postGig::withTrashed()->findOrFail($id);
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

            $postGig = $this->gigService->createPostGig(
                $request->only(['post_link', 'description', 'type']) + ['author_id' => auth('admin-api')->id()]
            );
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
            $this->gigService->deletePostGig((int) $id);
            return successResponse([]);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return failedResponse('This gig no longer exists.');
        } catch (Exception $e) {
            return failedResponse($e->getMessage());
        }
    }

    /**
     * POST /post-gig/{id}/restore
     */
    public function restorePostGig($id)
    {
        try {
            return successResponse($this->gigService->restorePostGig((int) $id));
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return failedResponse('This gig no longer exists.');
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
