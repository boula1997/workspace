<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('categories', function (Blueprint $table) {

            $table->string('model')->nullable()->after('type');

            // Comma separated values (stored as string)
            $table->text('search_keys')->nullable()->after('model');

            $table->string('config_class')->nullable()->after('search_keys');

        });
    }

    public function down(): void
    {
        Schema::table('categories', function (Blueprint $table) {

            $table->dropColumn([
                'model',
                'search_keys',
                'config_class',
            ]);

        });
    }
};