<?php

namespace App\Http\Requests\Games\Level;

use App\Http\Requests\BaseFormRequest;
use Illuminate\Foundation\Http\FormRequest;

class CreateRequest extends BaseFormRequest
{
    public function rules(): array
    {
        return [
            'game_id' => 'required|exists:games,id',
            'number' => 'required|integer',
            'title' => 'required|string|max:255',
            'status' => 'required|in:pending,published',
        ];
    }
}
