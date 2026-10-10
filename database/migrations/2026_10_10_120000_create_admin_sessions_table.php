<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * One row per signed-in device. API tokens are JWTs (stateless), so this table is what lets an
 * admin see where their account is signed in: a row is created at login (or the first time an
 * older token is used), touched as the token is used, and closed at logout.
 */
return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('admin_sessions')) {
            return;
        }

        Schema::create('admin_sessions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('admin_id')->constrained('admins')->cascadeOnDelete();
            $table->string('jti', 64)->unique();
            $table->string('device_name', 100)->nullable();
            $table->string('ip_address', 45)->nullable();
            $table->string('user_agent', 512)->nullable();
            $table->timestamp('last_active_at')->nullable();
            $table->timestamp('revoked_at')->nullable();
            $table->timestamps();

            $table->index(['admin_id', 'revoked_at']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('admin_sessions');
    }
};
