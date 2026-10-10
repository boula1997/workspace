<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

/**
 * Adds "audit_logs" to the app's index-tab modules (categories of type "modules").
 * The title is the table name, which is how the app addresses a module.
 */
return new class extends Migration
{
    public function up(): void
    {
        if (DB::table('categories')->where('type', 'modules')->where('title', 'audit_logs')->exists()) {
            return;
        }

        $row = [
            'title' => 'audit_logs',
            'type' => 'modules',
            'icon' => 'fas fa-history',
            'model' => 'App\\Models\\AuditLog',
            'search_keys' => 'model,event,admin_name',
            'config_class' => 'App\\CategoryConfigs\\AuditLogCategoryConfig',
            'created_at' => now(),
            'updated_at' => now(),
        ];

        // The active flag is "isActive" on MySQL; some Postgres copies have it folded to "isactive".
        $columns = Schema::getColumnListing('categories');
        foreach (['isActive', 'isactive'] as $flag) {
            if (in_array($flag, $columns, true)) {
                $row[$flag] = 1;
                break;
            }
        }

        DB::table('categories')->insert(array_intersect_key($row, array_flip($columns)));
    }

    public function down(): void
    {
        DB::table('categories')->where('type', 'modules')->where('title', 'audit_logs')->delete();
    }
};
