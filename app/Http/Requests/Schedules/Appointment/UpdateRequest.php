<?php

namespace App\Http\Requests\Schedules\Appointment;

use App\Http\Requests\BaseFormRequest;
use Illuminate\Foundation\Http\FormRequest;

class UpdateRequest extends BaseFormRequest
{
    public function rules(): array
    {
        return [
            'title' => 'nullable|string|max:512',
            'appointment_date' => 'nullable|date',
            'status' => 'nullable|in:pending,confirmed,cancelled,completed',
            'patient_status' => 'nullable|in:emergency,needs_follow_up,stable',
            'notes' => 'nullable|string',
            'cancel_reason' => 'required_if:status,cancelled|nullable|string',
        ];
    }
}
