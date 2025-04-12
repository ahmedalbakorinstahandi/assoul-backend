<?php




namespace App\Http\Services\Games;

use App\Services\MessageService;
use App\Http\Permissions\Games\GamePermission;
use App\Models\Games\Game;
use App\Models\Users\User;
use App\Services\FilterService;
use App\Services\FirebaseService;

class GameService
{
    public function index($data)
    {
        $query = Game::query();

        $data['sort_order'] = 'asc';
        $data['sort_field'] = 'order';

        $searchFields = ['name', 'color'];
        $numericFields = ['order'];
        $dateFields = ['created_at'];
        $exactMatchFields = ['is_enable'];
        $inFields = ['name'];

        $query = GamePermission::index($query);

        $query = FilterService::applyFilters(
            $query,
            $data,
            $searchFields,
            $numericFields,
            $dateFields,
            $exactMatchFields,
            $inFields
        );

        return $query;
    }

    public function show($id)
    {
        $game = Game::find($id);

        if (!$game) {
            MessageService::abort(404, 'Game not found');
        }

        GamePermission::show($game);

        return $game;
    }

    public function create($data)
    {
        $data = GamePermission::create($data);

        $game = Game::create($data);

        if ($game->is_enable) {
            $this->sendNotificationOnGameCreation($game);
        }

        return $game;
    }

    public function update(Game $game, $data)
    {

        $game_is_enable = $game->is_enable;

        $game->update($data);

        if ($game->is_enable && !$game_is_enable) {
            $this->sendNotificationOnGameCreation($game);
        }

        return $game;
    }


    public function sendNotificationOnGameCreation(Game $game)
    {
        // child:notification
        $users = User::where('role', 'patient')->get();
        FirebaseService::sendToTopicAndStorage(
            'role-children',
            $users->pluck('id')->toArray(),
            [
                'id' => $game->id,
                'type' => Game::class,
            ],
            'لعبة جديدة متاحة',
            'لعبة جديدة متاحة بعنوان ' . $game->title,
            'info',
        );
    }

    public function delete(Game $game)
    {
        $game->levels()->each(function ($level) {
            $level->questions()->each(function ($question) {
                $question->answers()->delete();
            });

            $level->questions()->delete();
        });

        $game->levels()->delete();

        return $game->delete();
    }
}
