<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Multiple choice options of an Academics question. `is_correct` marks the right option(s);
     * a question with no options keeps working as a plain question and answer card.
     */
    public function up(): void
    {
        if (Schema::hasTable('academic_item_options')) {
            return;
        }

        Schema::create('academic_item_options', function (Blueprint $table) {
            $table->id();
            $table->foreignId('academic_item_id')->constrained('academic_items')->cascadeOnDelete();
            $table->text('option_text');
            $table->boolean('is_correct')->default(false);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('academic_item_options');
    }
};
