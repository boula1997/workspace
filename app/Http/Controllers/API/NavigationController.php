<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\NavigationResource;
use App\Models\Navigation;
use Exception;
use Illuminate\Http\Request;

class NavigationController extends Controller
{
    private $navigation;

    public function __construct(Navigation $navigation)
    {
        $this->navigation = $navigation;
    }

    /**
     * GET /navigations
     * Returns all navigation entries.
     */
    public function index()
    {
        try {
            $data['navigations'] = NavigationResource::collection($this->navigation->get());
            return successResponse($data);
        } catch (Exception $e) {
            return failedResponse($e->getMessage());
        }
    }

    /**
     * GET /navigations/{id}
     * Returns a single navigation entry.
     */
    public function show($id)
    {
        try {
            $data['navigation'] = new NavigationResource($this->navigation->findorfail($id));
            return successResponse($data);
        } catch (Exception $e) {
            return failedResponse($e->getMessage());
        }
    }

    /**
     * GET /links
     * Returns paginated navigation links (Boula-only, with search support).
     */
    public function links(Request $request)
    {
        try {
            if (boula()) {
                $links = Navigation::query();

                if ($request->filled('search')) {
                    $links->where('title', 'like', '%' . $request->input('search') . '%');
                }

                $links = $links->orderBy('title', 'asc')->paginate(10);
            } else {
                $links = new \Illuminate\Pagination\LengthAwarePaginator([], 0, 10);
            }

            return successResponse([
                'links' => [
                    'data'         => NavigationResource::collection($links)->resolve(),
                    'current_page' => $links->currentPage(),
                    'last_page'    => $links->lastPage(),
                    'per_page'     => $links->perPage(),
                    'total'        => $links->total(),
                ],
                'isExpired' => isExpired()[0],
            ]);
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    /**
     * PUT /links/{id}/extra
     * Updates the 'extra' field of a navigation entry.
     */
    public function updateExtra(Request $request, $id)
    {
        $request->validate([
            'extra' => 'nullable|string',
        ]);

        $navigation = Navigation::findOrFail($id);
        $navigation->update(['extra' => $request->input('extra')]);

        return successResponse(new NavigationResource($navigation));
    }
}
