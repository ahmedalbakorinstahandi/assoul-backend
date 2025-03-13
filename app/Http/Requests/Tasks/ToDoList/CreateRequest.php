<?php

namespace App\Http\Requests\Tasks\ToDoList;

use App\Http\Requests\BaseFormRequest;
use Illuminate\Foundation\Http\FormRequest;

class CreateRequest extends BaseFormRequest
{

    public function rules(): array
    {
        return [
            'title' => 'required|string|max:255',
            'patient_id' => 'required|exists:patients,id',
            'assigned_by' => 'nullable|exists:guardians,id',
        ];
    }
}
