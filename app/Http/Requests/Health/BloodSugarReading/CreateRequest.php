<?php

namespace App\Http\Requests\Health\BloodSugarReading;

use App\Http\Requests\BaseFormRequest;
use App\Models\Users\User;
use Illuminate\Foundation\Http\FormRequest;

class CreateRequest extends BaseFormRequest
{

    public function rules(): array
    {
        $rules = [
            'measurement_type' => 'required|in:fasting,befor_breakfast,befor_lunch,befor_dinner,after_snack,after_breakfast,after_lunch,after_dinner,befor_activity,after_activity',
            'value' => 'required|numeric|min:0|max:999.99',
            'unit' => 'required|in:mg/dL,mmol/L',
            'notes' => 'nullable|string',
            'measured_at' => 'required|date_format:Y-m-d H:i:s',
        ];

        $user = User::auth();

        if (!$user->isPatient()) {
            $rules['patient_id'] = 'required|exists:patients,id';
        }

        return $rules;
    }
}
