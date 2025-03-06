<?php

namespace App\Http\Permissions\Games;

use App\Models\Games\Question;
use App\Models\Users\User;
use App\Services\MessageService;

class QuestionPermission
{
    public static function index($query)
    {
        return $query;
    }

    public static function show(Question $question)
    {
        return $question;
    }

    public static function create($data)
    {
        return $data;
    }

    public static function update(Question $question, $data)
    {
        return $data;
    }

    public static function delete(Question $question)
    {
        return $question;
    }
}
