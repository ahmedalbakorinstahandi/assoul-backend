<?php

namespace App\Http\Requests\Games\Question;

use App\Http\Requests\BaseFormRequest;
use Illuminate\Foundation\Http\FormRequest;

class NextQuestionRequest extends BaseFormRequest
{
    public function rules(): array
    {
        return [
            // level_id
            'level_id' => 'required|exists:levels,id',
        ];
    }
}
