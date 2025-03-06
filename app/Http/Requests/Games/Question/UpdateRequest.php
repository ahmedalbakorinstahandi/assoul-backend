<?php

namespace App\Http\Requests\Games\Question;

use App\Http\Requests\BaseFormRequest;

class UpdateRequest extends BaseFormRequest
{
    public function rules(): array
    {
        return [
            'text' => 'nullable|string',
            'image' => 'nullable|string|max:110',
            'points' => 'nullable|integer|min:1',
            'type' => 'nullable|in:MCQ,DragDrop,LetterArrangement',
            'level_id' => 'nullable|exists:levels,id',
            'answers_view' => 'nullable|in:text,image',
        ];
    }
}
