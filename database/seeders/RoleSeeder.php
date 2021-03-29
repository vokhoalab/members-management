<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $roles[] = [
            'name'         => 'admin',
            'guard_name' => 'admin',
        ];
        $roles[] = [
            'name'         => 'member',
            'guard_name' => 'admin',
        ];

        foreach ($roles as $role) {
            Role::create($role);
        }
    }
}
