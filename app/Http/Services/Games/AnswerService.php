<?php

namespace App\Http\Services\Games;

use App\Services\MessageService;
use App\Http\Permissions\Games\AnswerPermission;
use App\Models\Games\Answer;
use App\Services\FilterService;

class AnswerService
{
    public function index($data)
    {
        $query = Answer::query()->with('question.level.game');

        $searchFields = ['text'];
        $exactMatchFields = ['is_correct', 'question_id'];
        $dateFields = ['created_at'];

        $query = AnswerPermission::index($query);

        return FilterService::applyFilters(
            $query,
            $data,
            $searchFields,
            [],
            $dateFields,
            $exactMatchFields
        );
    }

    public function show($id)
    {
        $answer = Answer::find($id);

        if (!$answer) {
            MessageService::abort(404, 'الإجابة غير موجودة');
        }

        AnswerPermission::show($answer);

        return $answer;
    }

    public function create($data)
    {
        $data = AnswerPermission::create($data);

        return Answer::create($data);
    }

    public function update(Answer $answer, $data)
    {
        AnswerPermission::update($answer, $data);

        $answer->update($data);

        return $answer;
    }

    public function delete(Answer $answer)
    {
        AnswerPermission::delete($answer);

        return $answer->delete();
    }
}
