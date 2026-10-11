<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

/**
 * "Super Admin" marks the owner account: boula() is true only for admins with this role.
 * It is given to nessimboula@gmail.com only and cannot be assigned from the admin forms.
 * The owner keeps their existing role(s) for normal permissions.
 */
return new class extends Migration
{
    private const ROLE = 'Super Admin';
    private const OWNER_EMAIL = 'nessimboula@gmail.com';

    public function up(): void
    {
        $role = Role::firstOrCreate(['name' => self::ROLE, 'guard_name' => 'admin']);

        // Only the owner holds it
        DB::table('model_has_roles')->where('role_id', $role->id)->delete();

        $ownerId = DB::table('admins')->where('email', self::OWNER_EMAIL)->value('id');
        if ($ownerId) {
            DB::table('model_has_roles')->insert([
                'role_id' => $role->id,
                'model_type' => \App\Models\Admin::class,
                'model_id' => $ownerId,
            ]);
        }

        app(PermissionRegistrar::class)->forgetCachedPermissions();
    }

    public function down(): void
    {
        $role = Role::where('name', self::ROLE)->where('guard_name', 'admin')->first();
        if ($role) {
            DB::table('model_has_roles')->where('role_id', $role->id)->delete();
            $role->delete();
        }

        app(PermissionRegistrar::class)->forgetCachedPermissions();
    }
};
