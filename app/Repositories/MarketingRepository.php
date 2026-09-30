<?php

namespace App\Repositories;

use App\Contracts\Repositories\MarketingRepositoryInterface;
use App\Models\Marketting;
use App\Models\Navigation;

class MarketingRepository implements MarketingRepositoryInterface
{
    public function createPost(string $text): Marketting
    {
        return Marketting::create(['text' => $text]);
    }

    public function paginatePosts(?string $search, int $perPage = 2): \Illuminate\Contracts\Pagination\LengthAwarePaginator
    {
        $query = Marketting::orderBy('created_at', 'desc');

        if (!empty($search)) {
            $query->where('text', 'like', '%' . $search . '%');
        }

        return $query->paginate($perPage);
    }

    public function deletePost(int $id): Marketting
    {
        $post = Marketting::findOrFail($id);
        $post->deleteFiles();
        $post->delete();
        return $post;
    }

    public function competitors(): \Illuminate\Database\Eloquent\Collection
    {
        return Navigation::where('category_id', 25)->get();
    }

    public function jobs(): \Illuminate\Database\Eloquent\Collection
    {
        return Navigation::where('category_id', 5)->get();
    }

    public function marketingTools(): \Illuminate\Database\Eloquent\Collection
    {
        return Navigation::where('category_id', 26)->get();
    }
}
