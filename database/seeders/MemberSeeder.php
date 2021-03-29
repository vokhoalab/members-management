<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Member;
use Carbon\Carbon;
use DB;
class MemberSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $members[] = [
            'data' => [
                'user_id'         => 1,
                'level' => 'director'
            ],
            'teams' => [1,2]
        ];       

        foreach ($members as $member) {
            $m = Member::create($member['data']);

            foreach ($member['teams'] as $team) {
                DB::table('team_members')->insert([
                    'team_id' => $team,
                    'member_id' => $m->id,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now()
                ]);
            }
        }

        
    }
}
