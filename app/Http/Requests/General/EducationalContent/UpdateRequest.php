<?php

namespace App\Http\Requests\General\EducationalContent;

use App\Http\Requests\BaseFormRequest;
use Illuminate\Foundation\Http\FormRequest;

class UpdateRequest extends BaseFormRequest
{
    public function rules(): array
    {
        return [
            'title' => 'nullable|string|max:255',
            'link' => 'nullable|url|max:255',
            'duration' => 'nullable|integer|min:1',
            'is_visible' => 'nullable|boolean',
        ];
    }
}