<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Optional port of a credential's database server. Empty = the driver's standard port
 * (3306 MySQL, 5432 PostgreSQL, 1433 SQL Server), exactly as before.
 */
return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasColumn('d_b_credentials', 'db_port')) {
            Schema::table('d_b_credentials', function (Blueprint $table) {
                $table->unsignedInteger('db_port')->nullable();
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasColumn('d_b_credentials', 'db_port')) {
            Schema::table('d_b_credentials', function (Blueprint $table) {
                $table->dropColumn('db_port');
            });
        }
    }
};
