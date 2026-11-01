<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Transfer texts: plain text pasted on one device (SQL tab > Transfer) so it can be fetched
     * and copied on another device.
     */
    public function up(): void
    {
        if (Schema::hasTable('transfer_texts')) {
            return;
        }

        Schema::create('transfer_texts', function (Blueprint $table) {
            $table->id();
            $table->longText('content');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('transfer_texts');
    }
};
