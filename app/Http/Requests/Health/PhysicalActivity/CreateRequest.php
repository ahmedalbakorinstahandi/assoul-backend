<?php

namespace App\Http\Requests\Health\PhysicalActivity;

use App\Http\Requests\BaseFormRequest;
use App\Models\Users\User;

class CreateRequest extends BaseFormRequest
{
    public function rules(): array
    {
        $rules = [
            'activity_date' => 'required|date',
            'activity_time' => 'required|in:6-8,8-10,10-12,12-14,14-16,16-18,18-20,20-22',
            'description' => 'nullable|string|max:255',
            'intensity' => 'required|in:low,moderate,high',
            'duration' => 'required|integer|min:1',
            'notes' => 'nullable|string',
        ];

        $user = User::auth();

        if (!$user->isPatient()) {
            $rules['patient_id'] = 'required|exists:patients,id';
        }

        return $rules;
    }
}
