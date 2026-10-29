<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Each admin's saved timers for the app's Timers tab: what the timer is for and how long it
     * runs. Whether one is running right now stays on the device.
     */
    public function up(): void
    {
        if (Schema::hasTable('timers')) {
            return;
        }

        Schema::create('timers', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('admin_id');
            $table->string('action');
            $table->unsignedInteger('duration_sec');
            $table->timestamps();

            $table->index('admin_id', 'timers_admin_id_index');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('timers');
    }
};
