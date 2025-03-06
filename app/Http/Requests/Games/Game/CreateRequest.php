<?php

namespace App\Http\Requests\Games\Game;

use App\Http\Requests\BaseFormRequest;
use Illuminate\Foundation\Http\FormRequest;

class CreateRequest extends BaseFormRequest
{

    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'image' => 'required|string|max:110',
            'is_enable' => 'required|boolean',
            'color' => 'required|string|max:255',
            'order' => 'required|integer',
        ];
    }
}
