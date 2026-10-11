<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Per-user switches for the remaining app tabs. They default to on, because these tabs were
 * always visible before; the dashboard can turn them off per user.
 */
return new class extends Migration
{
    private const TABS = ['account', 'explore', 'logout'];

    public function up(): void
    {
        Schema::table('admins', function (Blueprint $table) {
            foreach (self::TABS as $tab) {
                if (!Schema::hasColumn('admins', $tab)) {
                    $table->boolean($tab)->default(true);
                }
            }
        });
    }

    public function down(): void
    {
        $existing = array_values(array_filter(self::TABS, fn ($tab) => Schema::hasColumn('admins', $tab)));

        if ($existing) {
            Schema::table('admins', function (Blueprint $table) use ($existing) {
                $table->dropColumn($existing);
            });
        }
    }
};
