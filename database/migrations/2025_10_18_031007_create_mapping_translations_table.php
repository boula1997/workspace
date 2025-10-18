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
        Schema::create('mapping_translations', function (Blueprint $table) {
            $table->id();
            $table->string('attribute_id');         // e.g., paymentMethod_id
            $table->string('translation_table');    // e.g., paymentMethod_translations
            $table->timestamps();
            $table->index('attribute_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mapping_translations');
    }
};
