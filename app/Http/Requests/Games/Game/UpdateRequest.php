<?php

namespace App\Http\Requests\Games\Game;

use App\Http\Requests\BaseFormRequest;
use Illuminate\Foundation\Http\FormRequest;

class UpdateRequest extends BaseFormRequest
{

    public function rules(): array
    {
        return [
            'name' => 'nullable|string|max:255',
            'image' => 'nullable|string|max:110',
            'is_enable' => 'nullable|boolean',
            'color' => 'nullable|string|max:255',
            'order' => 'nullable|integer',
        ];
    }
}
