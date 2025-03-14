<?php

namespace App\Http\Services\Games;

use App\Services\MessageService;
use App\Http\Permissions\Games\QuestionPermission;
use App\Models\Games\Level;
use App\Models\Games\PatientAnswer;
use App\Models\Games\Progress;
use App\Models\Games\Question;
use App\Models\Users\User;
use App\Services\FilterService;

class QuestionService
{
    public function index($data)
    {
        $query = Question::query()->with(['answers', 'level.game']);

        $searchFields = ['text'];
        $numericFields = ['points'];
        $dateFields = ['created_at'];
        $exactMatchFields = ['type', 'answers_view', 'level_id'];
        $inFields = ['type'];

        $query = QuestionPermission::index($query);

        return FilterService::applyFilters(
            $query,
            $data,
            $searchFields,
            $numericFields,
            $dateFields,
            $exactMatchFields,
            $inFields
        );
    }

    public function show($id)
    {
        $question = Question::find($id);

        if (!$question) {
            MessageService::abort(404, 'السؤال غير موجود');
        }

        QuestionPermission::show($question);

        $question->load('answers');

        return $question;
    }

    public function create($data)
    {
        $data = QuestionPermission::create($data);

        return Question::create($data);
    }

    public function update(Question $question, $data)
    {
        QuestionPermission::update($question, $data);

        $question->update($data);

        return $question;
    }

    public function delete(Question $question)
    {
        QuestionPermission::delete($question);

        $question->answers()->delete();

        return $question->delete();
    }

    public function getNextQuestion($data)
    {
        $level = Level::find($data['level_id']);

        $level_status = $level->getChildLevelStatus();

        if ($level_status == 'locked') {
            MessageService::abort(404, 'هذا المستوى مغلق');
        }

        $user = User::auth();

        $patient = $user->patient;

        $question = $level->questions()
            ->where('level_id', $level->id)
            ->whereDoesntHave('progresses', function ($query) use ($patient) {
                $query->where('patient_id', $patient->id);
            })
            ->first();

        if ($question) {
            $question->load('answers');
        }

        return $question;
    }

    //answerQuestion
    public function answerQuestion($question, $data)
    {

        $user = User::auth();

        $patient = $user->patient;

        $progress = $question->progresses()
            ->where('patient_id', $patient->id)
            ->first();

        if ($progress) {
            MessageService::abort(404, 'لقد قمت بالإجابة على هذا السؤال مسبقًا');
        }


        $answer_is_correct = false;

        if ($question->type == 'LetterArrangement') {
            $answer = $data['answer'];
            if ($question->answers->first()->text = $answer) {
                $answer_is_correct = true;
            }
        } else {
            $answer_id = $data['answer'];
            $answer = $question->answers()
                ->where('id', $answer_id)
                ->where('is_correct', true)
                ->first();

            if ($answer) {
                $answer_is_correct = true;
            }
        }

        $progress = Progress::create([
            'game_id' => $question->level->game->id,
            'level_id' => $question->level->id,
            'question_id' => $question->id,
            'patient_id' => $patient->id,
            'points' => $answer_is_correct ? $question->points : 0,
        ]);

        PatientAnswer::create([
            'patient_id' => $patient->id,
            'question_id' => $question->id,
            'answer_id' => $question->type != 'LetterArrangement' ? $data['answer'] : null,
            'custom_answer' => $question->type == 'LetterArrangement' ? $data['answer'] : null,
        ]);

        if ($answer_is_correct) {
            $patient->points += $question->points;
            $patient->save();
        }


        return $answer_is_correct;
    }
}
