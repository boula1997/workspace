<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

/**
 * Which Index-tab modules (categories of type "modules") each admin may see and edit.
 * Super admins see every module whatever is stored here. Until now every other admin saw only
 * "fees" and "projects", so every existing admin starts with those two.
 */
return new class extends Migration
{
    private const DEFAULT_MODULES = ['fees', 'projects'];

    public function up(): void
    {
        if (!Schema::hasTable('admin_category')) {
            Schema::create('admin_category', function (Blueprint $table) {
                $table->id();
                $table->foreignId('admin_id')->constrained('admins')->cascadeOnDelete();
                $table->foreignId('category_id')->constrained('categories')->cascadeOnDelete();
                $table->timestamps();
                $table->unique(['admin_id', 'category_id']);
            });
        }

        $moduleIds = DB::table('categories')
            ->where('type', 'modules')
            ->whereIn('title', self::DEFAULT_MODULES)
            ->pluck('id');

        if ($moduleIds->isEmpty()) {
            return;
        }

        $now = now();
        $rows = [];
        foreach (DB::table('admins')->pluck('id') as $adminId) {
            foreach ($moduleIds as $categoryId) {
                $rows[] = ['admin_id' => $adminId, 'category_id' => $categoryId, 'created_at' => $now, 'updated_at' => $now];
            }
        }

        // insertOrIgnore: running this again never duplicates a pair (unique index)
        foreach (array_chunk($rows, 500) as $chunk) {
            DB::table('admin_category')->insertOrIgnore($chunk);
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('admin_category');
    }
};
