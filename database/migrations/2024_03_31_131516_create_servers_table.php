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
        //dd("Make sure you took a backup of data");
        Schema::create('servers', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('project');
            $table->string('employee');
            $table->boolean('necessary')->default(0);
            $table->boolean('automation')->default(0);
            $table->boolean('ask')->default(0);
            $table->boolean('easy')->default(0);
            $table->boolean('committed')->default(0);
            $table->boolean('personal')->default(0);
            $table->boolean('color')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('issues');
    }
};
