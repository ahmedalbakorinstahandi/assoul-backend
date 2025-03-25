<?php

namespace App\Http\Requests\Patients\DoctorPatient;

use App\Http\Requests\BaseFormRequest;
use Illuminate\Foundation\Http\FormRequest;

class FollowRequest extends BaseFormRequest
{
    public function rules(): array
    {
        return [
            'doctor_id' => 'required|exists:users,id,deleted_at,NULL',
            'patient_id' => 'required|exists:users,id,deleted_at,NULL',
        ];
    }
}
