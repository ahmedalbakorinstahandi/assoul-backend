<?php

namespace App\Http\Services\Games;

use App\Http\Permissions\Games\LevelPermission;
use App\Models\Games\Level;
use App\Models\Users\User;
use App\Services\FilterService;
use App\Services\FirebaseService;
use App\Services\MessageService;

class LevelService
{
    public function index($data)
    {
        $query = Level::query()->with('game');

        $data['sort_order'] = 'asc';
        $data['sort_field'] = 'number';

        $searchFields = ['title'];
        $numericFields = ['number'];
        $dateFields = ['created_at'];
        $exactMatchFields = ['game_id'];
        $inFields = ['status', 'number'];

        $query = LevelPermission::index($query);

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
        $level = Level::find($id);

        if (!$level) {
            MessageService::abort(404, 'المستوى غير موجود');
        }

        LevelPermission::show($level);

        return $level;
    }

    public function create($data)
    {
        $data = LevelPermission::create($data);

        $level = Level::create($data);

        return $level;
    }

    public function update($level, $data)
    {

        $data = LevelPermission::update($level, $data);

        $level_status = $level->status;

        $level->update($data);

        if ($level->status == 'published' && $level_status == 'pending') {
            $this->sendNotificationToChildren($level);
        }

        return $level;
    }

    public function sendNotificationToChildren($level)
    {
        // child:notification
        $users = User::where('role', 'patient')->get();
        FirebaseService::sendToTopicAndStorage(
            'role-children',
            $users->pluck('id')->toArray(),
            [
                'id' =>   $level->id,
                'type' => Level::class,
            ],
            'مستوى جديد متاح',
            'مستوى جديد متاح في اللعبة ' . $level->game->title,
            'info',
        );
    }


    public function delete($level)
    {
        LevelPermission::delete($level);

        $level->questions->each(function ($question) {
            $question->answers()->delete();
        });

        $level->questions()->delete();

        return $level->delete();
    }


    public function getNextQuestion($level)
    {

        $level_status =   $level->getChildLevelStatus();

        if ($level_status == 'locked') {
            MessageService::abort(404, 'هذا المستوى مغلق');
        }

        $user = User::auth();

        $patient = $user->patient;

        $question = $level->questions()
            ->where('level_id', $level->id)
            ->whereDoesntHave('progress', function ($query) use ($patient) {
                $query->where('patient_id', $patient->id);
            })
            ->first();

        return $question;
    }
}
