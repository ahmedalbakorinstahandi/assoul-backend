<?php

namespace App\Http\Requests\Schedules\Appointment;

use App\Http\Requests\BaseFormRequest;
use App\Models\Users\User;
use Illuminate\Foundation\Http\FormRequest;

class CreateRequest extends BaseFormRequest
{
    public function rules(): array
    {
        $rules = [
            'patient_id' => 'required|exists:patients,id',
            'guardian_id' => 'required|exists:guardians,id',
            'doctor_id' => 'required|exists:doctors,id',
            'appointment_date' => 'required|date|after:now',
            // 'status' => 'required|in:pending,confirmed,cancelled,completed',
            'patient_status' => 'required|in:emergency,needs_follow_up,stable',
            'notes' => 'nullable|string',
        ];


        $user = User::auth();

        if ($user->isPatient()) {
            unset($rules['patient_id']);
        }

        if ($user->isGuardian()) {
            unset($rules['guardian_id']);
        }

        if ($user->isDoctor()) {
            unset($rules['doctor_id']);
            unset($rules['guardian_id']);
        }

        return $rules;
    }
}
