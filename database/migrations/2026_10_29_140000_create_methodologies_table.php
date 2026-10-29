<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Methodologies: a titled description of how to approach something (for example how to
     * investigate a stuck shipment). Shared by every database credential in the SQL tab.
     */
    public function up(): void
    {
        if (Schema::hasTable('methodologies')) {
            return;
        }

        Schema::create('methodologies', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->longText('description');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('methodologies');
    }
};
