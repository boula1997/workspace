<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Sale gigs also keep what the system solves and what to discuss with the owner.
     */
    public function up(): void
    {
        Schema::table('sale_gigs', function (Blueprint $table) {
            if (!Schema::hasColumn('sale_gigs', 'solved_problems')) {
                $table->text('solved_problems')->nullable()->after('description');
            }
            if (!Schema::hasColumn('sale_gigs', 'owner_discussion')) {
                $table->text('owner_discussion')->nullable()->after('solved_problems');
            }
        });
    }

    public function down(): void
    {
        Schema::table('sale_gigs', function (Blueprint $table) {
            $table->dropColumn(['solved_problems', 'owner_discussion']);
        });
    }
};
