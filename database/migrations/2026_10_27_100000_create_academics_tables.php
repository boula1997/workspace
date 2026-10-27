<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Study topics ("academics", e.g. GitHub CI/CD) that each hold question and answer cards
     * ("academic_items"), for learning by self-quizzing. Personal to each admin.
     */
    public function up(): void
    {
        if (! Schema::hasTable('academics')) {
            Schema::create('academics', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('admin_id')->index();
                $table->string('title');
                $table->timestamps();
            });
        }

        if (! Schema::hasTable('academic_items')) {
            Schema::create('academic_items', function (Blueprint $table) {
                $table->id();
                $table->foreignId('academic_id')->constrained('academics')->cascadeOnDelete();
                $table->text('question');
                $table->text('answer');
                $table->timestamps();
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('academic_items');
        Schema::dropIfExists('academics');
    }
};
