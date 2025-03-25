<?php

namespace App\Http\Requests\Notifications\ScheduledNotification;

use App\Http\Requests\BaseFormRequest;
use Illuminate\Foundation\Http\FormRequest;

class UpdateRequest extends  BaseFormRequest
{
    public function rules(): array
    {
        return [
            'title' => 'nullable|string|max:255',
            'content' => 'nullable|string',
            'image' => 'nullable|string|max:110',
            'type' => 'nullable|in:daily,weekly,monthly,yearly',
            'month' => 'required_if:type,yearly|nullable|integer|min:1|max:12',
            'week' => 'required_if:type,weekly|nullable|integer|min:1|max:53',
            'day' => 'required_if:type,monthly,yearly|nullable|integer|min:1|max:31',
            'time' => 'required|date_format:H:i',
            'status' => 'required|in:active,inactive',
        ];
    }
}
