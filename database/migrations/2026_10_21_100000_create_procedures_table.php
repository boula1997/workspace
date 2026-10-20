<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Procedures: a titled list of SELECT queries that are run one after another to follow what
     * happened during a process (for example a shipment from creation to delivery).
     * select_queries holds the queries separated by ";".
     */
    public function up(): void
    {
        if (Schema::hasTable('procedures')) {
            return;
        }

        Schema::create('procedures', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->longText('select_queries');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('procedures');
    }
};
