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
        Schema::create('searches', function (Blueprint $table) {
            $table->id();
            $table->string('title'); // The search query text
            $table->unsignedBigInteger('d_b_credential_id')->nullable(); // Foreign key to credentials
            $table->boolean('isActive')->default(1);
            $table->boolean('isFixed')->default(0);
            $table->timestamps();
            
            // Add foreign key constraint if you have a credentials table
            $table->foreign('d_b_credential_id')->references('id')->on('d_b_credentials')->onDelete('set null');
            
            // Add indexes for better performance
            $table->index('d_b_credential_id');
            $table->index('isActive');
            $table->index('isFixed');
            $table->index('created_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('searches');
    }
};