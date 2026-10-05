<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Track WHICH user created each gig history so ordering and counts can be per user.
     * Existing rows keep admin_id = NULL (recorded before per-user tracking existed).
     */
    public function up(): void
    {
        foreach (['call_histories' => 'phone_gig_id', 'link_histories' => 'post_gig_id'] as $tableName => $gigColumn) {
            if (!Schema::hasTable($tableName) || Schema::hasColumn($tableName, 'admin_id')) {
                continue;
            }

            Schema::table($tableName, function (Blueprint $table) use ($gigColumn, $tableName) {
                $table->unsignedBigInteger('admin_id')->nullable();
                $table->index(['admin_id', $gigColumn], $tableName . '_admin_gig_index');
            });
        }
    }

    public function down(): void
    {
        foreach (['call_histories' => 'phone_gig_id', 'link_histories' => 'post_gig_id'] as $tableName => $gigColumn) {
            if (!Schema::hasTable($tableName) || !Schema::hasColumn($tableName, 'admin_id')) {
                continue;
            }

            Schema::table($tableName, function (Blueprint $table) use ($tableName) {
                $table->dropIndex($tableName . '_admin_gig_index');
                $table->dropColumn('admin_id');
            });
        }
    }
};
