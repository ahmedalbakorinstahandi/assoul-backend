<?php

namespace App\Http\Requests\Health\Meal;

use App\Http\Requests\BaseFormRequest;

class UpdateRequest extends BaseFormRequest
{
    public function rules(): array
    {
        return [
            'consumed_date' => 'nullable|date',
            'type' => 'nullable|in:breakfast,lunch,dinner,snack',
            'carbohydrates_calories' => 'nullable|string',
            'description' => 'nullable|string|max:255',
            'notes' => 'nullable|string',
        ];
    }
}
