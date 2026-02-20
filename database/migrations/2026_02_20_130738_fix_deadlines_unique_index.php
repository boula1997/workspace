<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('deadlines', function (Blueprint $table) {
            // Drop old unique index on title
            $table->dropUnique('deadlines_title_unique');

            // Add composite unique index
            $table->unique(
                ['title', 'deadlineable_id', 'deadlineable_type'],
                'deadlines_unique_per_model'
            );
        });
    }

    public function down(): void
    {
        Schema::table('deadlines', function (Blueprint $table) {
            $table->dropUnique('deadlines_unique_per_model');
            $table->unique('title', 'deadlines_title_unique');
        });
    }
};
