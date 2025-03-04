<?php

namespace App\Http\Requests\Health\InsulinDose;

use App\Http\Requests\BaseFormRequest;

class UpdateRequest extends BaseFormRequest
{
    public function rules(): array
    {
        return [
            'taken_date' => 'nullable|date',
            'taken_time' => 'nullable|in:befor_breakfast_2h,befor_lunch_2h,befor_dinner_2h',
            'insulin_type' => 'nullable|string|max:255',
            'dose_units' => 'nullable|numeric|min:0',
            'injection_site' => 'nullable|in:arm,thigh,abdomen,lower_back',
        ];
    }
}
