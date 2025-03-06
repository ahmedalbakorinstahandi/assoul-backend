<?php

namespace App\Http\Permissions\Games;

use App\Models\Games\Game;
use App\Models\Users\User;
use App\Services\MessageService;

class GamePermission
{
    public static function index($query)
    {

        $user = User::auth();

        if (!$user->isAdmin()) {
            $query->where('is_enable', true);
        }

        return $query;
    }

    public static function show(Game $game)
    {

        $user = User::auth();

        if (!$user->isAdmin() && !$game->is_enable) {
            MessageService::abort(403, 'اللعبة غير مفعلة');
        }

        return $game;
    }

    public static function create($data)
    {
        return $data;
    }

    public static function update(Game $game, $data)
    {
        return $data;
    }

    public static function delete(Game $game)
    {
        return $game;
    }
}
