<?php

namespace App\Http\Requests\Users\Guardian;

use App\Http\Requests\BaseFormRequest;
use Illuminate\Foundation\Http\FormRequest;

class UpdateProfileRequest extends BaseFormRequest
{
    public function rules(): array
    {
        return [
            'user.first_name' => 'nullable|sometimes|string|max:50',
            'user.last_name' => 'nullable|sometimes|string|max:50',
            'user.phone' => 'nullable|sometimes|string|max:255',
            'user.avatar' => 'nullable|sometimes|image|mimes:jpeg,png,jpg,gif|max:2048',
            'user.password' => 'nullable|sometimes|string|min:8|confirmed',
        ];
    }
}
