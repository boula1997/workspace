<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * The app's Counters tab: categories (e.g. "Home maintenance") holding items, each with a count
     * of things still to do and an optional note, plus a history of every count / note change.
     * Rows are keyed by a uuid made on the device, so changes made offline sync without id mapping.
     */
    public function up(): void
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
                // The device change that produced this row: replaying a sync never adds it twice
                $table->string('op_uuid', 64)->unique();
                $table->string('item_uuid', 64);
                $table->string('field', 20); // count | note
                $table->text('old_value')->nullable();
                $table->text('new_value')->nullable();
                // When the change was made on the device (it may reach the server later)
                $table->timestamp('changed_at')->nullable();
                $table->timestamps();

                $table->index(['admin_id', 'item_uuid'], 'counter_histories_admin_item_index');
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('counter_histories');
        Schema::dropIfExists('counter_items');
        Schema::dropIfExists('counter_categories');
    }
};
