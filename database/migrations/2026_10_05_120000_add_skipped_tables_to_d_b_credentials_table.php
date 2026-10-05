<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasColumn('d_b_credentials', 'skipped_tables')) {
            Schema::table('d_b_credentials', function (Blueprint $table) {
                // Comma separated table names whose row-count/timestamp checks are skipped
                $table->text('skipped_tables')->nullable();
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasColumn('d_b_credentials', 'skipped_tables')) {
            Schema::table('d_b_credentials', function (Blueprint $table) {
                $table->dropColumn('skipped_tables');
            });
        }
    }
};
