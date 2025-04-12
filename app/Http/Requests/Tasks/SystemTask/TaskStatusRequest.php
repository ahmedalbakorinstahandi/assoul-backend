<?php

namespace App\Http\Requests\Tasks\SystemTask;

use App\Http\Requests\BaseFormRequest;
use App\Models\Users\User;
use Illuminate\Foundation\Http\FormRequest;

class TaskStatusRequest extends BaseFormRequest
{

    public function rules(): array
    {
        $rules = [
            'status' => 'required|in:completed,not_completed',
            'completed_at' => 'required|date',
        ];


        $user = User::auth();

        if (!$user->isPatient()) {
            $rules['patient_id'] = 'required|exists:patients,id,deleted_at,NULL';
        }

        return $rules;
    }
}
