<?php


namespace App\Http\Permissions\Games;


use App\Models\Games\Level;
use App\Models\Users\User;
use App\Services\MessageService;

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
        if (isset($data['status'])) {
            if ($data['status'] == 'published') {
                if (!$level->canPublish()) {
                    MessageService::abort(400, 'لا يمكن نشر المستوى، يجب تحقيق الشروط اللازمة أولاً');
                }
            } elseif ($level->status == 'published' && $data['status'] == 'published') {
                MessageService::abort(400, 'المستوى تم نشره بالفعل');
            }
        }

        return $data;
    }

    public static function delete(Level $level)
    {
        return $level;
    }
}
