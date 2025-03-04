<?php

namespace App\Http\Requests\Health\InsulinDose;

use App\Http\Requests\BaseFormRequest;
use App\Models\Users\User;

class CreateRequest extends BaseFormRequest
{
    public function rules(): array
    {
        $rules = [
            'taken_date' => 'required|date',
            'taken_time' => 'required|in:befor_breakfast_2h,befor_lunch_2h,befor_dinner_2h',
            'insulin_type' => 'required|string|max:255',
            'dose_units' => 'required|numeric|min:0',
            'injection_site' => 'required|in:arm,thigh,abdomen,lower_back',
        ];

        $user = User::auth();

        if (!$user->isPatient()) {
            $rules['patient_id'] = 'required|exists:patients,id';
        }

        return $rules;
    }
}
