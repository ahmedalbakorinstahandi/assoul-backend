<?php

namespace App\Http\Requests\Users\Guardian;

use App\Http\Requests\BaseFormRequest;
use App\Models\Users\User;
use Illuminate\Foundation\Http\FormRequest;

class AddChildRequest extends BaseFormRequest
{
    public function rules(): array
    {
        $rules = [
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'gender' => 'required|string|in:male,female,other',
            'birth_date' => 'required|date',
            'height' => 'required|numeric|min:0',
            'weight' => 'required|numeric|min:0',
            'diabetes_diagnosis_age' => 'required|integer|min:0',
        ];

        $user = User::auth();

        if ($user->isAdmin()) {
            $rules['guardian_id'] = 'exists:guardians,id,deleted_at,NULL';
        }

        return $rules;
    }
}
