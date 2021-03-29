<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Permission;
use App\Models\Role;

class RoleAndPermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        /** @var Role $admin */
        $admin = Role::whereName('admin')->first();
        /** @var Role $member */
        $member = Role::whereName('member')->first();

        $permissions = Permission::all();
        $admin->givePermissionTo($permissions);

        $permissions = Permission::whereNotIn('name', ['manage_roles'])->get();
        $member->givePermissionTo($permissions);
    }
}
