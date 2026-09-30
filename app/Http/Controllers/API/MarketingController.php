<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Services\MarketingService;
use Exception;
use Illuminate\Http\Request;

class MarketingController extends Controller
{
    protected $marketingService;

    public function __construct(MarketingService $marketingService)
    {
        $this->marketingService = $marketingService;
    }

    /**
     * POST /marketing/create-post
     * Creates a new marketing post with optional images.
     */
    public function createPost(Request $request)
    {
        try {
            $post = $this->marketingService->createPost($request->text);

            if ($request->has('images')) {
                $destinationPath = public_path('uploads/marketing');
                if (!file_exists($destinationPath)) {
                    mkdir($destinationPath, 0755, true);
                }

                foreach ($request->images as $image) {
                    $base64 = $image['base64'] ?? null;
                    if (!$base64) continue;

                    if (strpos($base64, 'base64,') !== false) {
                        $base64 = explode('base64,', $base64)[1];
                    }
                    $imageBinary = base64_decode($base64);
                    if ($imageBinary === false) continue;

                    $extension = pathinfo($image['name'], PATHINFO_EXTENSION) ?: 'jpg';
                    $filename  = time() . '_' . uniqid() . '.' . $extension;

                    file_put_contents($destinationPath . '/' . $filename, $imageBinary);

                    $post->files()->create([
                        'url' => 'uploads/marketing/' . $filename,
                    ]);
                }
            }

            return successResponse($post->load('files'));
        } catch (Exception $e) {
            return failedResponse($e->getMessage());
        }
    }

    /**
     * GET /marketing/get-posts
     * Returns a paginated list of marketing posts.
     */
    public function getPosts(Request $request)
    {
        try {
            $perPage = $request->input('per_page', 2);
            $search  = $request->input('search');

            $posts = $this->marketingService->getPaginatedPosts($search, $perPage);

            return successResponse([
                'posts'      => $posts->items(),
                'posts_meta' => [
                    'current_page' => $posts->currentPage(),
                    'last_page'    => $posts->lastPage(),
                    'total'        => $posts->total(),
                    'per_page'     => $posts->perPage(),
                ],
            ]);
        } catch (Exception $e) {
            return failedResponse($e->getMessage());
        }
    }

    /**
     * DELETE /marketing/delete-post/{id}
     * Deletes a marketing post and its associated files.
     */
    public function deletePost($id)
    {
        try {
            $this->marketingService->deletePost($id);
            return successResponse(['message' => 'Post deleted successfully']);
        } catch (Exception $e) {
            return failedResponse($e->getMessage());
        }
    }

    /**
     * GET /competitors
     * Returns competitor links from the navigation structure.
     */
    public function competitors()
    {
        $links = $this->marketingService->getCompetitors();
        return successResponse($links);
    }

    /**
     * GET /jobs
     * Returns job links from the navigation structure.
     */
    public function jobs()
    {
        $links = $this->marketingService->getJobs();
        return successResponse($links);
    }

    /**
     * GET /marketing-tools
     * Returns marketing tool links.
     */
    public function marketingTools()
    {
        $links = $this->marketingService->getMarketingTools();
        return successResponse($links);
    }
}
