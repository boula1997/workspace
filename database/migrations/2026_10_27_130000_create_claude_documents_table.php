<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * One free-text document per admin (their CLAUDE.md), edited from the app.
     */
    public function up(): void
    {
        if (Schema::hasTable('claude_documents')) {
            return;
        }

        Schema::create('claude_documents', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('admin_id')->unique();
            $table->longText('content')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('claude_documents');
    }
};
