<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Switch for the app's Academics tab. Off until turned on per admin from the dashboard.
 */
return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasColumn('admins', 'academics')) {
            return;
        }

        Schema::table('admins', function (Blueprint $table) {
            $table->boolean('academics')->default(false);
        });
    }

    public function down(): void
    {
        if (Schema::hasColumn('admins', 'academics')) {
            Schema::table('admins', function (Blueprint $table) {
                $table->dropColumn('academics');
            });
        }
    }
};
