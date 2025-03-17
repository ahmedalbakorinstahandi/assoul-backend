<?php

namespace App\Http\Requests\Patients\MedicalRecord;

use App\Http\Requests\BaseFormRequest;
use Illuminate\Foundation\Http\FormRequest;

class CreateRequest extends BaseFormRequest
{
    public function rules(): array
    {
        return [
            'title' => 'required|string',
            'description' => 'required|string',
            'patient_id' => 'required|exists:patients,id',
        ];
    }
}
