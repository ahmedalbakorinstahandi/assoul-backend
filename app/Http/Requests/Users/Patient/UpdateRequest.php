<?php

namespace App\Http\Requests\Users\Patient;

use App\Http\Requests\BaseFormRequest;
use Illuminate\Foundation\Http\FormRequest;

class UpdateRequest extends BaseFormRequest
{
    public function rules(): array
    {
        return [
            'user.first_name' => 'required|string|max:255',
            'user.last_name' => 'required|string|max:255',
            'user.avatar' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'gender' => 'required|string|in:male,female,other',
            'birth_date' => 'required|date',
            'height' => 'required|numeric|min:0',
            'weight' => 'required|numeric|min:0',
            'diabetes_diagnosis_age' => 'required|integer|min:0',
            'insulin_doses' => 'required|integer|min:1',
        ];
    }
}
