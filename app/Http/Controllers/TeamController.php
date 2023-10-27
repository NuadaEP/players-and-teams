<?php

namespace App\Http\Controllers;

use App\Http\Requests\TeamRequest;
use App\Models\Player;

class TeamController extends Controller
{
    public function __invoke(TeamRequest $request)
    {
        $data = $request->validated();

        $team = Array();

        foreach($data['position'] as $position)
        {
            $players = Player::join('skills', 'players.id', '=', 'skills.player_id')
                ->where('position', $position)
                ->whereIn('skill', $data['skills'])
                ->orderBy('value', 'desc')
                ->limit(1)
                ->get();

            $team[] = $players[0];
        }


        return $team;
    }
}
