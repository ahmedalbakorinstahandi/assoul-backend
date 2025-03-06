<?php

namespace App\Http\Requests\Games\Question;

use App\Http\Requests\BaseFormRequest;

class CreateRequest extends BaseFormRequest
{
    public function rules(): array
    {
        return [
            'text' => 'required|string',
            'image' => 'required|string|max:110',
            'points' => 'required|integer|min:1',
            'type' => 'required|in:MCQ,DragDrop,LetterArrangement',
            'level_id' => 'required|exists:levels,id',
            'answers_view' => 'required|in:text,image',
        ];
    }
}
