<?php

namespace App\Http\Requests\Tasks\SystemTask;

use App\Http\Requests\BaseFormRequest;
use Illuminate\Foundation\Http\FormRequest;

class CreateRequest extends BaseFormRequest
{
    public function rules(): array
    {
        return [
            'title' => 'required|string|max:255',
            'points' => 'required|integer|min:0',
            'image' => 'required|string|max:110',
            'unique_key' => 'required|string|unique:system_tasks,unique_key',
        ];
    }
}
