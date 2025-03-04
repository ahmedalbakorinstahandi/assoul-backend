<?php

namespace App\Http\Requests\Health\PhysicalActivity;

use App\Http\Requests\BaseFormRequest;

class UpdateRequest extends BaseFormRequest
{
    public function rules(): array
    {
        return [
            'activity_date' => 'nullable|date',
            'activity_time' => 'nullable|in:6-8,8-10,10-12,12-14,14-16,16-18,18-20,20-22',
            'description' => 'nullable|string|max:255',
            'intensity' => 'nullable|in:low,moderate,high',
            'duration' => 'nullable|integer|min:1',
            'notes' => 'nullable|string',
        ];
    }
}
