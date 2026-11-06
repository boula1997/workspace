<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * The app's Counters tab was removed: drop its tables (made by
     * 2026_11_06_100000_create_counters_tables). This deletes their data, so back up first.
     */
    public function up(): void
    {
        Schema::dropIfExists('counter_histories');
        Schema::dropIfExists('counter_items');
        Schema::dropIfExists('counter_categories');
    }

    // Recreates the (empty) tables, as the create migration made them
    public function down(): void
    {
        if (!Schema::hasTable('counter_categories')) {
            Schema::create('counter_categories', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('admin_id');
                $table->string('uuid', 64)->unique();
                $table->string('name');
                $table->timestamps();

                $table->index('admin_id', 'counter_categories_admin_id_index');
            });
        }

        if (!Schema::hasTable('counter_items')) {
            Schema::create('counter_items', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('admin_id');
                $table->string('uuid', 64)->unique();
                $table->string('category_uuid', 64);
                $table->string('title');
                $table->integer('count')->default(0);
                $table->text('note')->nullable();
                $table->boolean('is_hidden')->default(false);
                $table->timestamps();

                $table->index(['admin_id', 'category_uuid'], 'counter_items_admin_category_index');
            });
        }

        if (!Schema::hasTable('counter_histories')) {
            Schema::create('counter_histories', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('admin_id');
                $table->string('op_uuid', 64)->unique();
                $table->string('item_uuid', 64);
                $table->string('field', 20);
                $table->text('old_value')->nullable();
                $table->text('new_value')->nullable();
                $table->timestamp('changed_at')->nullable();
                $table->timestamps();

                $table->index(['admin_id', 'item_uuid'], 'counter_histories_admin_item_index');
            });
        }
    }
};
