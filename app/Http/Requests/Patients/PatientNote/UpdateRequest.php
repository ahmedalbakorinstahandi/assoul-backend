<?php

namespace App\Http\Requests\Patients\PatientNote;

use App\Http\Requests\BaseFormRequest;
use Illuminate\Foundation\Http\FormRequest;

class UpdateRequest extends BaseFormRequest
{
    public function rules(): array
    {
        return [
            'content' => 'nullable|string',
            'patient_id' => 'nullable|exists:patients,id',
        ];
    }
}
