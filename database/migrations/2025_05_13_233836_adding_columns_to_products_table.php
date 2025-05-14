<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('products', function (Blueprint $table) {

            $table->double('hdd')->nullable();

            $table->double('ssd')->nullable();

            $table->double('ram')->nullable();

            $table->string('processor')->nullable();

            $table->string('generation')->nullable();

            $table->string('screenCard')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {

            $table->dropColumn('hdd');

            $table->dropColumn('ssd');

            $table->dropColumn('ram');

            $table->dropColumn('processor');

            $table->dropColumn('generation');

            $table->dropColumn('screenCard');
        });
    }
};
