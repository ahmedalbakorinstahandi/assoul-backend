<?php

namespace App\Http\Requests\Users\Guardian;

use App\Http\Requests\BaseFormRequest;
use Illuminate\Foundation\Http\FormRequest;

class UpdateRequest extends BaseFormRequest
{
    public function rules(): array
    {
        return [
            'user.first_name' => 'nullable|string|max:255',
            'user.last_name' => 'nullable|string|max:255',
            'user.avatar' => 'nullable|string|max:110',
            'user.phone' => 'nullable|string|max:255',
            'user.password' => 'nullable|string|min:6|confirmed',
        ];
    }
}
