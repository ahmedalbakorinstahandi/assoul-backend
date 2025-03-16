<?php

namespace App\Http\Requests\Users\Patient;

use App\Http\Requests\BaseFormRequest;
use Illuminate\Foundation\Http\FormRequest;

class UpdateRequest extends BaseFormRequest
{
    public function rules(): array
    {
        return [
            'user.first_name' => 'nullable|string|max:255',
            'user.last_name' => 'nullable|string|max:255',
            'user.avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'gender' => 'nullable|string|in:male,female,other',
            'birth_date' => 'nullable|date',
            'height' => 'nullable|numeric|min:0',
            'weight' => 'nullable|numeric|min:0',
            'diabetes_diagnosis_age' => 'nullable|integer|min:0',
            'insulin_doses' => 'nullable|integer|min:1',
        ];
    }
}
