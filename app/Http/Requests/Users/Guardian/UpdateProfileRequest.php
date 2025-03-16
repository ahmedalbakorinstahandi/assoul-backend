<?php

namespace App\Http\Requests\Users\Guardian;

use App\Http\Requests\BaseFormRequest;
use Illuminate\Foundation\Http\FormRequest;

class UpdateProfileRequest extends BaseFormRequest
{
    public function rules(): array
    {
        return [
            'user.first_name' => 'nullable|string|max:50',
            'user.last_name' => 'nullable|string|max:50',
            'user.phone' => 'nullable|string|max:255',
            'user.avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'user.password' => 'nullable|string|min:6|confirmed',
        ];
    }
}
