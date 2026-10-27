<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Lets a question be hidden from study (e.g. once it is known) without deleting it.
     */
    public function up(): void
    {
        if (Schema::hasColumn('academic_items', 'is_hidden')) {
            return;
        }

        Schema::table('academic_items', function (Blueprint $table) {
            $table->boolean('is_hidden')->default(false);
        });
    }

    public function down(): void
    {
        if (Schema::hasColumn('academic_items', 'is_hidden')) {
            Schema::table('academic_items', function (Blueprint $table) {
                $table->dropColumn('is_hidden');
            });
        }
    }
};
