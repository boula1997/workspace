<?php

namespace App\Contracts\Repositories;

interface GigRepositoryInterface
{
    // Phone Gigs
    public function createPhoneGig(array $data): \App\Models\phoneGig;
    public function paginatePhoneGigs(int $perPage = 15, ?int $adminId = null): \Illuminate\Contracts\Pagination\LengthAwarePaginator;
    public function deletePhoneGig(int $id): \App\Models\phoneGig;
    public function restorePhoneGig(int $id): \App\Models\phoneGig;
    public function phoneGigExists(string $phone): bool;

    // Post Gigs
    public function createPostGig(array $data): \App\Models\postGig;
    public function paginatePostGigs(int $perPage = 15, ?int $adminId = null): \Illuminate\Contracts\Pagination\LengthAwarePaginator;
    public function deletePostGig(int $id): \App\Models\postGig;
    public function restorePostGig(int $id): \App\Models\postGig;

    // Sale Gigs (title + description, no contact)
    public function createSaleGig(array $data): \App\Models\saleGig;
    public function deleteSaleGig(int $id): \App\Models\saleGig;
    public function restoreSaleGig(int $id): \App\Models\saleGig;

    // Phone, post and sale gigs in one filtered, paginated feed
    public function paginateGigFeed(array $filters, int $perPage, ?int $adminId): \Illuminate\Contracts\Pagination\LengthAwarePaginator;
    public function gigFeedFacets(array $filters, ?int $adminId): array;

    // Histories
    public function createCallHistory(int $phoneGigId, ?int $adminId = null): \App\Models\CallHistory;
    public function createLinkHistory(int $postGigId, ?int $adminId = null): \App\Models\LinkHistory;

    // Per-user history statistics for one gig
    public function phoneGigHistoryStats(int $phoneGigId, ?int $adminId): array;
    public function postGigHistoryStats(int $postGigId, ?int $adminId): array;
}
