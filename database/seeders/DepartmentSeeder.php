<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Department;

class DepartmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $departments[] = [
            'name'         => 'Technology Department',
            'manager' => 'Tran Van An',
            'description' => 'Technology Department'
        ];

        $departments[] = [
            'name'         => 'Sales Department',
            'manager' => 'Ngo Van Dong',
            'description' => 'Sales Department'
        ];
        

        foreach ($departments as $department) {
            Department::create($department);
        }
    }
}
