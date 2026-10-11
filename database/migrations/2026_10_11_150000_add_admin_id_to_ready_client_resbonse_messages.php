<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

/**
 * Ready messages per admin:
 *  - admin_id: the admin the message belongs to (empty = shared, used by admins with no messages
 *    of their own). Existing messages are given to the admin named "Boula N".
 *  - The table becomes a module of the app's index tab, where each message's admin is picked.
 */
return new class extends Migration
{
    private const TABLE = 'ready_client_resbonse_messages';
    private const OWNER_NAME = 'Boula N';
    private const MODULE = [
        'title' => 'ready_client_resbonse_messages',
        'type' => 'modules',
        'icon' => 'fas fa-comment-dots',
        'model' => 'App\\Models\\ReadyClientResbonseMessage',
        'search_keys' => 'message,admin.name,gig_type,language',
        'config_class' => 'App\\CategoryConfigs\\BaseCategoryConfig',
    ];

    public function up(): void
    {
        if (Schema::hasTable(self::TABLE) && !Schema::hasColumn(self::TABLE, 'admin_id')) {
            // Existing messages belong to the admin named "Boula N"; stop before changing anything if
            // that admin is missing or the name is not unique.
            $ownerIds = DB::table('admins')->where('name', self::OWNER_NAME)->pluck('id');
            if ($ownerIds->count() !== 1) {
                throw new RuntimeException(
                    'Expected exactly one admin named "' . self::OWNER_NAME . '" to own the existing ready messages, found '
                    . $ownerIds->count() . '. Nothing was changed.'
                );
            }

            Schema::table(self::TABLE, function (Blueprint $table) {
                $table->unsignedBigInteger('admin_id')->nullable()->index();
            });

            DB::table(self::TABLE)->whereNull('admin_id')->update(['admin_id' => $ownerIds->first()]);
        }

        if (!DB::table('categories')->where('type', 'modules')->where('title', self::MODULE['title'])->exists()) {
            $columns = Schema::getColumnListing('categories');
            $row = self::MODULE + ['created_at' => now(), 'updated_at' => now()];
            foreach (['isActive', 'isactive'] as $flag) {
                if (in_array($flag, $columns, true)) {
                    $row[$flag] = 1;
                    break;
                }
            }
            DB::table('categories')->insert(array_intersect_key($row, array_flip($columns)));
        }
    }

    public function down(): void
    {
        DB::table('categories')->where('type', 'modules')->where('title', self::MODULE['title'])->delete();

        if (Schema::hasTable(self::TABLE) && Schema::hasColumn(self::TABLE, 'admin_id')) {
            Schema::table(self::TABLE, function (Blueprint $table) {
                $table->dropIndex(['admin_id']);
                $table->dropColumn('admin_id');
            });
        }
    }
};
