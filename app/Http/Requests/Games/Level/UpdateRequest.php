<?php

namespace App\Http\Requests\Games\Level;

use App\Http\Requests\BaseFormRequest;
use Illuminate\Foundation\Http\FormRequest;

class UpdateRequest extends BaseFormRequest
{

    public function rules(): array
    {
        return [
            'number' => 'nullable|integer|integer',
            'title' => 'nullable|string|max:255',
            'status' => 'nullable|in:published',
        ];
    }
}
