<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Marketting;
use App\Models\Navigation;
use App\Http\Resources\PostResource;
use Exception;
use Illuminate\Http\Request;

class MarketingController extends Controller
{
    /**
     * POST /marketing/create-post
     * Creates a marketing post with optional base64 images.
     */
    public function createPost(Request $request)
    {
        $post = Marketting::create([
            'text' => $request->text,
        ]);

        if ($request->has('images') && is_array($request->images)) {
            foreach ($request->images as $imageData) {
                $base64   = $imageData['base64'];
                $filename = $imageData['name'] ?? uniqid() . '.jpg';
                $mimeType = $imageData['type'] ?? 'image/jpeg';

                // Remove data:image/jpeg;base64, prefix if present
                if (strpos($base64, 'base64,') !== false) {
                    $base64 = explode('base64,', $base64)[1];
                }

                $imageBinary    = base64_decode($base64);
                $uniqueFilename = uniqid() . '_' . $filename;
                $path           = 'images/' . $uniqueFilename;

                $tempPath = tempnam(sys_get_temp_dir(), 'img');
                file_put_contents($tempPath, $imageBinary);

                $file = new \Illuminate\Http\UploadedFile(
                    $tempPath,
                    $filename,
                    $mimeType,
                    null,
                    true
                );

                $file->move('images', $uniqueFilename);
                $post->files()->create(['url' => $path]);

                if (file_exists($tempPath)) {
                    unlink($tempPath);
                }
            }
        }

        return successResponse($post);
    }

    /**
     * GET /marketing/get-posts
     * Returns paginated marketing posts with optional text search.
     */
    public function getPosts(Request $request)
    {
        $query = Marketting::orderBy('created_at', 'desc');

        if ($request->has('search') && !empty($request->search)) {
            $query->where('text', 'like', '%' . $request->search . '%');
        }

        $posts = $query->paginate(2);

        return successResponse(PostResource::collection($posts->items()), $posts);
    }

    /**
     * DELETE /marketing/delete-post/{id}
     * Deletes a marketing post and its associated files.
     */
    public function deletePost($id)
    {
        $post = Marketting::find($id);
        $post->deleteFiles();
        $post->delete();

        return successResponse($post);
    }

    /**
     * GET /competitors
     * Returns navigation entries in the competitors category (id=25).
     */
    public function competitors(Request $request)
    {
        $competitors = Navigation::where('category_id', 25)->get();
        return successResponse($competitors);
    }

    /**
     * GET /jobs
     * Returns navigation entries in the jobs category (id=5).
     */
    public function jobs(Request $request)
    {
        $jobs = Navigation::where('category_id', 5)->get();
        return successResponse($jobs);
    }

    /**
     * GET /marketing-tools
     * Returns navigation entries in the marketing tools category (id=26).
     */
    public function marketingTools(Request $request)
    {
        $tools = Navigation::where('category_id', 26)->get();
        return successResponse($tools);
    }
}
