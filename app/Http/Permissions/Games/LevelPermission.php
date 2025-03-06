<?php


namespace App\Http\Permissions\Games;


use App\Models\Games\Level;
use App\Models\Users\User;

class LevelPermission
{
    public static function index($query)
    {
        $user = User::auth();
        if (!$user->isAdmin()) {

            $game_id = request()->input('game_id');

            if (!$game_id) {
                $game_id = 0;
            }

            $query->where('game_id', $game_id);
        }

        return $query;
    }

    public static function show(Level $level)
    {
        return $level;
    }

    public static function create($data)
    {
        return $data;
    }

    public static function update(Level $level, $data)
    {
        return $data;
    }

    public static function delete(Level $level)
    {
        return $level;
    }
}
