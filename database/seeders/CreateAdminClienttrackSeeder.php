<?php
  
namespace Database\Seeders;

use App\Models\Admin;
use Illuminate\Database\Seeder;
use App\Models\Clienttrack;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
  
class CreateAdminClienttrackSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        
        $clienttrack1 = Admin::create([
            'name' => 'Boula', 
            'email' => 'admin@gmail.com',
            'type' => 'admin',
            'password' => bcrypt('123456789')
        ]);
        $clienttrack2 = Admin::create([
            'name' => 'Kermina', 
            'email' => 'kermina@gmail.com',
            'type' => 'employee',
            'password' => bcrypt('123456789')
        ]);
        $clienttrack3 = Admin::create([
            'name' => 'Ibrahim', 
            'email' => 'ibrahim@gmail.com',
            'type' => 'employee',
            'password' => bcrypt('123456789')
        ]);
        $clienttrack4 = Admin::create([
            'name' => 'Konuz', 
            'email' => 'konuz@gmail.com',
            'type' => 'employee',
            'password' => bcrypt('123456789')
        ]);
        $clienttrack5 = Admin::create([
            'name' => 'Melad', 
            'email' => 'melad@gmail.com',
            'type' => 'employee',
            'password' => bcrypt('123456789')
        ]);
        $clienttrack6 = Admin::create([
            'name' => 'Tadros', 
            'email' => 'tadros@gmail.com',
            'password' => bcrypt('123456789')
        ]);
    
        $role = Role::create(['name' => 'Admin','guard_name'=>'admin']);

        $role2 = Role::create(['name' => 'Employee','guard_name'=>'admin']);
     
        $permissions = Permission::pluck('id','id')->all();
   
        $role->syncPermissions($permissions);
        $role2->syncPermissions($permissions);
     
        $clienttrack1->assignRole([$role->id]);
        $clienttrack2->assignRole([$role2->id]);
        $clienttrack3->assignRole([$role2->id]);
        $clienttrack4->assignRole([$role2->id]);
        $clienttrack5->assignRole([$role2->id]);
        $clienttrack6->assignRole([$role2->id]);
    }
}
