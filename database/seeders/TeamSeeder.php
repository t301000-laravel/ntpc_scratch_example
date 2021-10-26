<?php

namespace Database\Seeders;

use App\Models\Team;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class TeamSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $list =[
            '國小遊戲組' =>  [
                '樹林國小', '育林國小', '三多國小', '永和國小', '自強國小',
                '中和國小', '積穗國小', '林口國小', '中正國小', '淡水國小',
            ],
            '國中遊戲組' =>  [
                '育林國中', '崇林國中', '新泰國中', '南山國中', '二重國中',
                '積穗國中', '秀峰國中', '正德國中', '自強國中', '忠孝國中',
            ],
        ];

        $prefix = [
            '國小遊戲組' => 'A',
            '國小動畫組' => 'B',
            '國中遊戲組' => 'C',
            '國中動畫組' => 'D',
        ];

        foreach ($list as $group => $teams) {
            foreach ($teams as $idx => $school_name) {
                $username = $prefix[$group] . Str::padLeft($idx + 1, 5, '0');
                $user = User::create([
                    'name' => $school_name,
                    'email' => $username . '@test.tw',
                    'username' => $username,
                    'password' => bcrypt('12345678'),
                ]);

                Team::create([
                    'user_id' => $user->id,
                    'school_name' => $user->name,
                    'game_group' => $group,
                ]);
            }
        }
    }
}
