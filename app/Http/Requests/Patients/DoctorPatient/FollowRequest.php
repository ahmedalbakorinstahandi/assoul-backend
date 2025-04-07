<?php

namespace App\Http\Requests\Patients\DoctorPatient;

use App\Http\Requests\BaseFormRequest;
use App\Models\Users\User;
use Illuminate\Foundation\Http\FormRequest;

class FollowRequest extends BaseFormRequest
{
    public function rules(): array
    {
        return [
            'doctor_id' => !User::auth()->isAdmin()  ? '' :  'required|exists:users,id,deleted_at,NULL',
            'patient_id' => 'required|exists:patients,id,deleted_at,NULL',
        ];
    }
}
