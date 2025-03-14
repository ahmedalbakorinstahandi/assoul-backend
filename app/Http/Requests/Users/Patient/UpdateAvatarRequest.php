<?php

namespace App\Http\Requests\Users\Patient;

use App\Http\Requests\BaseFormRequest;
use Illuminate\Foundation\Http\FormRequest;

class UpdateAvatarRequest extends BaseFormRequest
{
    public function rules(): array
    {
        return [
            'avatar' => 'required|image|mimes:jpeg,png,jpg,gif|max:4096',
        ];
    }
}
