<?php

namespace App\Http\Requests\Games\Question;

use App\Http\Requests\BaseFormRequest;
use App\Models\Games\Question;
use App\Services\MessageService;
use Illuminate\Foundation\Http\FormRequest;

class AnswerQuestionRequest extends BaseFormRequest
{
    public function rules(): array
    {
        $question = Question::find($this->route('id'));

        if(!$question) {
            MessageService::abort(404, 'السؤال غير موجود');
        }

        if ($question->type == 'LetterArrangement') {
            return [
                'answer' => 'required|string'
            ];
        } else {
            return [
                'answer' => 'required|exists:answers,id'
            ];
        }
    }
}
