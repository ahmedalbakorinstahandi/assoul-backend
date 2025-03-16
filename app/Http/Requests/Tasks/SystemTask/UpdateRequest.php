<?php

namespace App\Http\Requests\Tasks\SystemTask;

use App\Http\Requests\BaseFormRequest;
use Illuminate\Foundation\Http\FormRequest;

class UpdateRequest extends BaseFormRequest
{
    public function rules(): array
    {
        return [
            'title' => 'nullable|string|max:255',
            'points' => 'nullable|integer',
            'image' => 'nullable|string|max:110',
            'unique_key' => 'nullable|string|max:255|unique:system_tasks,unique_key,deleted_at,NULL',
        ];
    }
}
