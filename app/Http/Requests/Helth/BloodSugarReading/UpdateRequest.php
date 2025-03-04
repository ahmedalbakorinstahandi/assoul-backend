<?php

namespace App\Http\Requests\Helth\BloodSugarReading;

use App\Http\Requests\BaseFormRequest;
use Illuminate\Foundation\Http\FormRequest;

class UpdateRequest extends BaseFormRequest
{

    public function rules(): array
    {
        return [
            'measurement_type' => 'nullable|in:fasting,befor_breakfast,befor_lunch,befor_dinner,after_snack,after_breakfast,after_lunch,after_dinner,befor_activity,after_activity',
            'value' => 'nullable|numeric|min:0|max:999.99',
            'unit' => 'nullable|in:mg/dL,mmol/L',
            'notes' => 'nullable|string',
            'measured_at' => 'nullable|date_format:Y-m-d H:i:s',
        ];
    }
}
