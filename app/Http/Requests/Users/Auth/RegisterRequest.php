<?php

namespace App\Http\Requests\Users\Auth;

use App\Http\Requests\BaseFormRequest;
use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends BaseFormRequest
{

    public function rules(): array
    {
        $rules = [
            'first_name' => 'required|string|max:50',
            'last_name' => 'required|string|max:50',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
            'phone' => 'required|string|max:255',
            'role' => 'required|string|in:guardian,doctor',
        ];


        if ($this->input('role') === 'doctor') {
            $rules['doctor.specialization'] = 'required|string|max:255';
            $rules['doctor.classification_number'] = 'required|string|max:255';
            $rules['doctor.workplace_clinic_location'] = 'required|string|max:255';
        }

        return $rules;
    }
}
