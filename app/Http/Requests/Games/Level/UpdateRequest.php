<?php

namespace App\Http\Requests\Games\Level;

use App\Http\Requests\BaseFormRequest;
use Illuminate\Foundation\Http\FormRequest;

class UpdateRequest extends BaseFormRequest
{

    public function rules(): array
    {
        return [
            'game_id' => 'nullable|exists:games,id',
            'number' => 'nullable|integer|unique:levels,number',
            'title' => 'nullable|string|max:255',
            'status' => 'nullable|in:published',
        ];
    }
}
