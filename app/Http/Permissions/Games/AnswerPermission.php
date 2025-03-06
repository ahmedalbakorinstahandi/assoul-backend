<?php

namespace App\Http\Permissions\Games;

use App\Models\Games\Answer;
use App\Models\Users\User;
use App\Services\MessageService;

class AnswerPermission
{
    public static function index($query)
    {
        return $query;
    }

    public static function show(Answer $answer)
    {
        return $answer;
    }

    public static function create($data)
    {
        return $data;
    }

    public static function update(Answer $answer, $data)
    {
        return $data;
    }

    public static function delete(Answer $answer)
    {
        return $answer;
    }
}
