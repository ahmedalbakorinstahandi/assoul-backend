<?php

namespace App\Http\Requests\Users\Doctor;

use App\Http\Requests\BaseFormRequest;
use Illuminate\Foundation\Http\FormRequest;

class CreateRequest extends BaseFormRequest
{
    public function rules(): array
    {
        return [
            'user.first_name' => 'required|string|max:255',
            'user.last_name' => 'required|string|max:255',
            'user.email' => 'required|email|unique:users,email',
            'user.phone' => 'required|string|max:255',
            'user.password' => 'required|string|min:6|confirmed',
            'user.avatar' => 'required|string|max:110',
            'specialization' => 'required|string|max:255',
            'classification_number' => 'required|string|max:255',
            'workplace_clinic_location' => 'required|string|max:255',
        ];
    }
}
