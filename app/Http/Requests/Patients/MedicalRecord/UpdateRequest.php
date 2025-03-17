<?php

namespace App\Http\Requests\Patients\MedicalRecord;

use App\Http\Requests\BaseFormRequest;
use Illuminate\Foundation\Http\FormRequest;

class UpdateRequest extends BaseFormRequest
{
    public function rules(): array
    {
        return [
            'title' => 'nullable|string',
            'description' => 'nullable|string',
            'patient_id' => 'nullable|exists:patients,id',
        ];
    }
}
