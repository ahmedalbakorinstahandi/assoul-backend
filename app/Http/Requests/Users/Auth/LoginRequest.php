<?php

namespace App\Http\Requests\Users\Auth;

use App\Http\Requests\BaseFormRequest;
use Illuminate\Foundation\Http\FormRequest;

class LoginRequest extends BaseFormRequest
{
    public function rules(): array
    {
        return [
            'role' => 'required|in:child,guardian,doctor,admin',
            'code' => 'required_if:role,child',
            'email' => 'required_unless:role,child|email',
            'password' => 'required_unless:role,child',
            'device_token' => 'nullable|string|min:10',
        ];
    }
}
