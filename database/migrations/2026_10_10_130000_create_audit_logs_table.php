<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

/**
 * Change history for sensitive records (finance: fees, accountants, accounts): who created,
 * changed or deleted what, when, and the old/new values. Rows are never edited or deleted by the
 * app. Admin details are copied in, so the history stays readable if that admin is removed later.
 *
 * Also adds the `finance-log-list` permission and gives it to every role that can already delete
 * fees (`fee-delete`). Other roles can be given it from the Roles page.
 */
return new class extends Migration
{
    private string $permission = 'finance-log-list';

    public function up(): void
    {
        if (!Schema::hasTable('audit_logs')) {
            Schema::create('audit_logs', function (Blueprint $table) {
                $table->id();
                $table->string('model', 50);
                $table->unsignedBigInteger('model_id')->nullable();
                $table->string('event', 20);
                $table->json('old_values')->nullable();
                $table->json('new_values')->nullable();
                $table->unsignedBigInteger('admin_id')->nullable();
                $table->string('admin_name')->nullable();
                $table->string('admin_email')->nullable();
                $table->string('channel', 20);
                $table->string('ip_address', 45)->nullable();
                $table->string('user_agent', 512)->nullable();
                $table->string('url', 500)->nullable();
                $table->timestamp('created_at')->useCurrent();

                $table->index(['model', 'model_id']);
                $table->index('admin_id');
                $table->index('created_at');
            });
        }

        $permission = Permission::firstOrCreate(['name' => $this->permission, 'guard_name' => 'admin']);
        Role::where('guard_name', 'admin')
            ->whereHas('permissions', fn ($query) => $query->where('name', 'fee-delete'))
            ->get()
            ->each(fn (Role $role) => $role->givePermissionTo($permission));
        app(PermissionRegistrar::class)->forgetCachedPermissions();
    }

    public function down(): void
    {
        Permission::where('name', $this->permission)->where('guard_name', 'admin')->delete();
        app(PermissionRegistrar::class)->forgetCachedPermissions();
        Schema::dropIfExists('audit_logs');
    }
};
