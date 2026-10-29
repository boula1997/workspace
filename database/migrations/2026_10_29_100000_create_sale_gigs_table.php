<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Sale gigs: a system we build first and then sell to clients. Only a title and a description,
     * no contact, so no history table either.
     */
    public function up(): void
    {
        if (Schema::hasTable('sale_gigs')) {
            return;
        }

        Schema::create('sale_gigs', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description')->nullable();
            $table->unsignedBigInteger('author_id')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->index('author_id', 'sale_gigs_author_id_index');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('sale_gigs');
    }
};
