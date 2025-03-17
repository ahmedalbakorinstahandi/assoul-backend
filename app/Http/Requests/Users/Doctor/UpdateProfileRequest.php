<?php

namespace App\Http\Requests\Users\Doctor;

use App\Http\Requests\BaseFormRequest;
use Illuminate\Foundation\Http\FormRequest;

class UpdateProfileRequest extends BaseFormRequest
{
    public function rules(): array
    {
        return [
            'user.first_name' => 'nullable|string|max:255',
            'user.last_name' => 'nullable|string|max:255',
            'user.phone' => 'nullable|string|max:255',
            'user.password' => 'nullable|string|min:6|confirmed',
            'user.avatar' => 'nullable|string|max:110',
            'specialization' => 'nullable|string|max:255',
            'classification_number' => 'nullable|string|max:255',
            'workplace_clinic_location' => 'nullable|string|max:255',
        ];
    }
}
