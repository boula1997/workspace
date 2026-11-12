<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

/**
 * Switches for the app's Timers, Money, CV and Quiz tabs.
 * Timers, Money and CV default to on, because they were always visible before they had a switch.
 * Quiz followed the Academics switch, so every admin starts with Quiz set like their Academics.
 */
return new class extends Migration
{
    private const ON_BY_DEFAULT = ['timers', 'money', 'cv'];

    public function up(): void
    {
        Schema::table('admins', function (Blueprint $table) {
            foreach (self::ON_BY_DEFAULT as $tab) {
                if (!Schema::hasColumn('admins', $tab)) {
                    $table->boolean($tab)->default(true);
                }
            }
        });

        if (Schema::hasColumn('admins', 'quiz')) {
            return;
        }

        Schema::table('admins', function (Blueprint $table) {
            $table->boolean('quiz')->default(false);
        });

        if (Schema::hasColumn('admins', 'academics')) {
            // Read in PHP rather than SQL so it works whatever type academics has on this database
            $withAcademics = DB::table('admins')->get(['id', 'academics'])
                ->filter(fn ($admin) => (bool) $admin->academics)
                ->pluck('id');

            if ($withAcademics->isNotEmpty()) {
                DB::table('admins')->whereIn('id', $withAcademics)->update(['quiz' => true]);
            }
        }
    }

    public function down(): void
    {
        $existing = array_values(array_filter(
            [...self::ON_BY_DEFAULT, 'quiz'],
            fn ($tab) => Schema::hasColumn('admins', $tab)
        ));

        if ($existing) {
            Schema::table('admins', function (Blueprint $table) use ($existing) {
                $table->dropColumn($existing);
            });
        }
    }
};
