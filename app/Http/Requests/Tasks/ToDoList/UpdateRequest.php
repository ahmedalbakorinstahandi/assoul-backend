<?php

namespace App\Http\Requests\Tasks\ToDoList;

use App\Http\Requests\BaseFormRequest;
use Illuminate\Foundation\Http\FormRequest;

class UpdateRequest extends BaseFormRequest
{
    public function rules(): array
    {
        return [
            'title' => 'nullable|string|max:255',
        ];
    }
}
