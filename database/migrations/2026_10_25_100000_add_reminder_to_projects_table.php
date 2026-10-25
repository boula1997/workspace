<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Per-project "something needs doing" flag, toggled from the app's Projects tab (no details, just on/off).
 */
return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasColumn('projects', 'reminder')) {
            return;
        }

        Schema::table('projects', function (Blueprint $table) {
            $table->boolean('reminder')->default(false);
        });
    }

    public function down(): void
    {
        if (Schema::hasColumn('projects', 'reminder')) {
            Schema::table('projects', function (Blueprint $table) {
                $table->dropColumn('reminder');
            });
        }
    }
};
