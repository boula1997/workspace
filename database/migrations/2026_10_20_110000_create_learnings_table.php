<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Things an admin wants to learn: a personal backlog to decide from, moved along as
     * "todo" (to learn) -> "learning" -> "done" (learned).
     */
    public function up(): void
    {
        if (Schema::hasTable('learnings')) {
            return;
        }

        Schema::create('learnings', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('admin_id')->index();
            $table->string('title');
            $table->text('notes')->nullable();
            $table->string('status', 20)->default('todo');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('learnings');
    }
};
