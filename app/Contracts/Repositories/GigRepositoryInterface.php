<?php

namespace App\Contracts\Repositories;

interface GigRepositoryInterface
{
    // Phone Gigs
    public function createPhoneGig(array $data): \App\Models\phoneGig;
    public function paginatePhoneGigs(int $perPage = 15): \Illuminate\Contracts\Pagination\LengthAwarePaginator;
    public function deletePhoneGig(int $id): \App\Models\phoneGig;
    public function phoneGigExists(string $phone): bool;

    // Post Gigs
    public function createPostGig(array $data): \App\Models\postGig;
    public function paginatePostGigs(int $perPage = 15): \Illuminate\Contracts\Pagination\LengthAwarePaginator;
    public function deletePostGig(int $id): \App\Models\postGig;

    // Histories
    public function createCallHistory(int $phoneGigId): \App\Models\CallHistory;
    public function createLinkHistory(int $postGigId): \App\Models\LinkHistory;
}
