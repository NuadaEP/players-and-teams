<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUpdatePlayer;
use App\Http\Resources\PlayerResource;
use Illuminate\Http\Request;
use App\Models\Player;
use App\Models\Skill;

class PlayerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $players = Player::paginate();

        return PlayerResource::collection($players);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreUpdatePlayer $request)
    {
        $data = $request->validated();

        $player = Player::create([
            'name' => $data['name'],
            'position' => $data['position'],
        ]);

        foreach ($data['playerSkills'] as $value) {
            Skill::create([
                'skill' => $value['skill'],
                'value' => $value['value'],
                'player_id' => $player['id']
            ]);
        }

        return new PlayerResource($player);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $player = Player::find($id);

        if (!$player)
        {
            return response()->json([
                'message' => 'Record not found',
            ], 400);
        }

        return PlayerResource::make($player);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StoreUpdatePlayer $request, string $id)
    {
        $data = $request->validated();

        $player = Player::find($id);

        $player->name = $data['name'];
        $player->position = $data['position'];

        $player->save();

        return PlayerResource::make($player);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, string $id)
    {
        $token = $request->header('Authorization');

        if (!$token)
        {
            return response()->json([
                'success' => false
            ], 400);
        }

        $bearerToken = explode(' ', $token);

        if ($bearerToken[0] !== 'Bearer' || $bearerToken[1] !== 'ABC123@#@#@#')
        {
            return response()->json([
                'success' => false
            ], 400);
        }

        Player::destroy($id);

        return response()->json([
            'success' => true
        ]);
    }
}
