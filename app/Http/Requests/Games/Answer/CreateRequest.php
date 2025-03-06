<?php

namespace App\Http\Requests\Games\Answer;

use App\Http\Requests\BaseFormRequest;

class CreateRequest extends BaseFormRequest
{
    public function rules(): array
    {
        return [
            'question_id' => 'required|exists:questions,id',
            'text' => 'nullable|string',
            'image' => 'nullable|string|max:110',
            'is_correct' => 'required|boolean',
        ];
    }
}
