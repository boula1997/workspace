<?php

namespace App\Contracts\Repositories;

interface MarketingRepositoryInterface
{
    public function createPost(string $text): \App\Models\Marketting;
    public function paginatePosts(?string $search, int $perPage = 2): \Illuminate\Contracts\Pagination\LengthAwarePaginator;
    public function deletePost(int $id): \App\Models\Marketting;
    public function competitors(): \Illuminate\Database\Eloquent\Collection;
    public function jobs(): \Illuminate\Database\Eloquent\Collection;
    public function marketingTools(): \Illuminate\Database\Eloquent\Collection;
}
