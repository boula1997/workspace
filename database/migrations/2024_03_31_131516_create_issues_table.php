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
        Schema::create('issues', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->longText('script')->nullable();
            $table->longText('codeLinks')->nullable();
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
