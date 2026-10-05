<?php

use App\Models\Admin;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    private const OWNER_NAME = 'Boula N';

    /**
     * All gig histories recorded before per-user tracking were made by Boula N,
     * so give them his admin_id (only rows that still have admin_id = NULL).
     */
    public function up(): void
    {
        $tables = array_filter(
            ['call_histories', 'link_histories'],
            fn ($t) => Schema::hasTable($t) && Schema::hasColumn($t, 'admin_id')
        );

        if (!$tables) {
            return;
        }

        $ids = Admin::where('name', self::OWNER_NAME)->pluck('id');

        // Fail loudly instead of assigning history to the wrong person (or nobody).
        if ($ids->count() !== 1) {
            throw new RuntimeException(
                'Expected exactly one admin named "' . self::OWNER_NAME . '" but found ' . $ids->count()
                . '. Aborting so gig histories are not assigned to the wrong user.'
            );
        }

        foreach ($tables as $table) {
            DB::table($table)->whereNull('admin_id')->update(['admin_id' => $ids->first()]);
        }
    }

    /**
     * Not reversible: after the backfill there is no way to tell which rows were
     * originally unassigned, so rolling back leaves the data as it is.
     */
    public function down(): void
    {
    }
};
