<?php

namespace App\Http\Requests\Patients\PatientNote;

use App\Http\Requests\BaseFormRequest;
use Illuminate\Foundation\Http\FormRequest;

class CreateRequest extends BaseFormRequest
{

    public function rules(): array
    {
        return [
            'content' => 'required|string',
            'patient_id' => 'required|exists:patients,id',
        ];
    }
}
