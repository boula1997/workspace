<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('d_b_credentials', function (Blueprint $table) {
            $table->string("db_host")->default("localhost");
        });
    }

    
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('d_b_credentials', function (Blueprint $table) {
           $table->dropColumn("db_host");
        });
    }
};
