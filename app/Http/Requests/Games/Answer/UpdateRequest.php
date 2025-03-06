<?php

namespace App\Http\Requests\Games\Answer;

use App\Http\Requests\BaseFormRequest;

class UpdateRequest extends BaseFormRequest
{
    public function rules(): array
    {
        return [
            'question_id' => 'nullable|exists:questions,id',
            'text' => 'nullable|string',
            'image' => 'nullable|string|max:110',
            'is_correct' => 'nullable|boolean',
        ];
    }
}
