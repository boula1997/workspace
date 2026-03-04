<?php
// database/migrations/xxxx_xx_xx_xxxxxx_create_commands_table.php

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
        Schema::create('commands', function (Blueprint $table) {
            $table->id();
            $table->foreignId('d_b_credential_id')->constrained('d_b_credentials')->onDelete('cascade');
            $table->string('title');
            $table->text('content')->nullable(); // The actual command/SQL content
            $table->string('database_name')->nullable(); // The database this command belongs to
            $table->boolean('is_fixed')->default(false); // For pinned/fixed commands
            $table->timestamps();
            
            // Optional indexes for better performance
            $table->index('d_b_credential_id');
            $table->index('title');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('commands');
    }
};