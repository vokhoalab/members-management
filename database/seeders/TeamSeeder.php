<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Team;

class TeamSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $teams[] = [
            'name'         => 'TO1 Project ERP',
            'description' => 'Project ERP',
            'department_id' => 1
        ];

        $teams[] = [
            'name'         => 'PO2 Sale Team',
            'description' => 'Sale Team',
            'department_id' => 2
        ];
        

        foreach ($teams as $team) {
            Team::create($team);
        }
    }
}
