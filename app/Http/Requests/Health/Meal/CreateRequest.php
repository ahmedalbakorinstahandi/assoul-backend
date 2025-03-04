<?php

namespace App\Http\Requests\Health\Meal;

use App\Http\Requests\BaseFormRequest;
use App\Models\Users\User;

class CreateRequest extends BaseFormRequest
{
    public function rules(): array
    {
        $rules = [
            'consumed_date' => 'required|date',
            'type' => 'required|in:breakfast,lunch,dinner,snack',
            'carbohydrates_calories' => 'nullable|string',
            'description' => 'required|string|max:255',
            'notes' => 'nullable|string',
        ];

        $user = User::auth();

        if (!$user->isPatient()) {
            $rules['patient_id'] = 'required|exists:patients,id';
        }

        return $rules;
    }
}
