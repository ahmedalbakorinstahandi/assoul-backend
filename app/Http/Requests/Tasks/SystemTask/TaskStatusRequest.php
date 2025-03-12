<?php

namespace App\Http\Requests\Tasks\SystemTask;

use App\Http\Requests\BaseFormRequest;
use Illuminate\Foundation\Http\FormRequest;

class TaskStatusRequest extends BaseFormRequest
{

    public function rules(): array
    {
        return [
            'status' => 'required|in:completed,not_completed',
            'created_at' => 'required|datetime',
        ];
    }
}
