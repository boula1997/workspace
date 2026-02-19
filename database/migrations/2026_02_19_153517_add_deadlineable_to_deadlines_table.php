<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('deadlines', function (Blueprint $table) {
            // Polymorphic relation
            $table->nullableMorphs('deadlineable'); // Adds deadlineable_id & deadlineable_type
        });
    }

    public function down(): void
    {
        Schema::table('deadlines', function (Blueprint $table) {
            $table->dropMorphs('deadlineable');
        });
    }
};

