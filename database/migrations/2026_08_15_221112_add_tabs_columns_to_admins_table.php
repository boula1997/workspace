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
        Schema::table('admins', function (Blueprint $table) {
          $table->boolean("table")->default(0);
          $table->boolean("projects")->default(0);
          $table->boolean("tasks")->default(0);
          $table->boolean("marketting")->default(0);
          $table->boolean("offline-center")->default(0);
          $table->boolean("locks")->default(0);
          $table->boolean("stats")->default(0);
          $table->boolean("info")->default(0);
          $table->boolean("workspace")->default(0);
          $table->boolean("sql")->default(0);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('admins', function (Blueprint $table) {
            //
        });
    }
};
