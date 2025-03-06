<?php

namespace App\Http\Services\Games;

use App\Http\Permissions\Games\LevelPermission;
use App\Models\Games\Level;
use App\Models\Users\User;
use App\Services\FilterService;
use App\Services\MessageService;

class LevelService
{



    public function index($data)
    {
        $query = Level::query();

        $data['sort_order'] = 'asc';
        $data['sort_field'] = 'number';

        $searchFields = ['name', 'color'];
        $numericFields = ['order'];
        $dateFields = ['created_at'];
        $exactMatchFields = ['is_enable'];
        $inFields = ['name'];

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

        $level->update($data);

        return $level;
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
