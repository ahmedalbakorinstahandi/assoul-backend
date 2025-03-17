<?php

namespace App\Http\Requests\Schedules\Appointment;

use App\Http\Requests\BaseFormRequest;
use Illuminate\Foundation\Http\FormRequest;

class CancelRequest extends BaseFormRequest
{
    public function rules(): array
    {
        return [
            'cancel_reason' => 'required|string|max:1020',
        ];
    }
}
