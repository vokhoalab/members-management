<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Permission;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {        
        $permissions[] = [
            'name'         => 'manage_roles',
            'guard_name' => 'admin',
        ];        
        $permissions[] = [
            'name'         => 'manage_users',
            'guard_name' => 'admin',
        ];      
        
        foreach ($permissions as $permission) {
            Permission::create($permission);
        }
    }
}
