<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class GameDashboardController extends Controller
{
    public function __invoke(Request $request, $group)
    {
        $players = User::with(['team', 'files' => function($q) {
            $q->limit(1);
        }])->whereRelation('team', 'game_group', $group)->get();
        //dd($players->toArray());

        $data = [
            'group' => $group,
            'players' => $players,
        ];

        return view('game-dashboard', $data);
    }
}
