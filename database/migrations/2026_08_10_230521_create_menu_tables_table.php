<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Schema::create('menu_tables', function (Blueprint $table) {
        //     $table->id();
        //     $table->string('child_table_name');
        //     $table->string('menu_name');
        //     $table->timestamps();
        // });
    }

    public function down(): void
    {
        Schema::dropIfExists('menu_tables');
    }
};