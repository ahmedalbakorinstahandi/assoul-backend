<?php

namespace App\Http\Requests\General\EducationalContent;

use App\Http\Requests\BaseFormRequest;
use Illuminate\Foundation\Http\FormRequest;

class CreateRequest extends BaseFormRequest
{
    public function rules(): array
    {
        return [
            'title' => 'required|string|max:255',
            'link' => 'required|url|max:255',
            'duration' => 'required|integer|min:1',
            'is_visible' => 'required|boolean',
        ];
    }
}