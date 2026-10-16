<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

/**
 * Switch for the app's Gigs tab. Gigs used to live inside Marketing, so whoever had Marketing
 * starts with Gigs on.
 */
return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasColumn('admins', 'gigs')) {
            return;
        }

        Schema::table('admins', function (Blueprint $table) {
            $table->boolean('gigs')->default(false);
        });

        // marketting is an integer column on some databases, so read it in PHP rather than in SQL
        $withMarketing = DB::table('admins')->get(['id', 'marketting'])
            ->filter(fn ($admin) => (bool) $admin->marketting)
            ->pluck('id');

        if ($withMarketing->isNotEmpty()) {
            DB::table('admins')->whereIn('id', $withMarketing)->update(['gigs' => true]);
        }
    }

    public function down(): void
    {
        if (Schema::hasColumn('admins', 'gigs')) {
            Schema::table('admins', function (Blueprint $table) {
                $table->dropColumn('gigs');
            });
        }
    }
};
