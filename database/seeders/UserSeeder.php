<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Role;
use App\Models\User;
use Carbon\Carbon;
use Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $userList[] = ['info'=>
            [
                'name'        => 'Nguyen Van A',
                'email'             => 'vana@gmail.com',
                'password'          => Hash::make('12345678'),
                'email_verified_at' => Carbon::now()
            ],
            ['role'=>'director']
        ];

        /** @var User $user */
        foreach ($userList as $user) {
            $user = User::create($user['info']);
            /** @var Role $directorRole */
            $role = Role::whereName($user['role'])->first();
            $user->roles()->attach($role);
        }
    }
}
