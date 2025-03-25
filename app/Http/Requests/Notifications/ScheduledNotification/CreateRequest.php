<?php

namespace App\Http\Requests\Notifications\ScheduledNotification;

use App\Http\Requests\BaseFormRequest;
use Illuminate\Foundation\Http\FormRequest;

class CreateRequest extends BaseFormRequest
{

    public function rules(): array
    {
        return [
            'title' => 'required|string|max:255',
            'content' => 'nullable|string',
            'image' => 'nullable|string|max:110',
            'type' => 'required|in:daily,weekly,monthly,yearly',
            'month' => 'required_if:type,yearly|nullable|integer|min:1|max:12',
            'week' => 'required_if:type,weekly|nullable|integer|min:1|max:53',
            'day' => 'required_if:type,monthly,yearly|nullable|integer|min:1|max:31',
            'time' => 'required|date_format:H:i',
            'status' => 'required|in:active,inactive',
        ];

        // daily: time
        // weekly: week, time   : 1, 2, 3, 4, 5, 6, 7
        // monthly: day, time   : 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, ... 31
        // yearly: month, day, time  : 1, 2, 3, 4, 5, 6, ... 12 | 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, ... 31


        // month 1 : 31 days
        // month 2 : 28 days if not leap year else 29
        // month 3 : 31 days
        // month 4 : 30 days
        // month 5 : 31 days
        // month 6 : 30 days
        // month 7 : 31 days
        // month 8 : 31 days
        // month 9 : 30 days
        // month 10 : 31 days
        // month 11 : 30 days
        // month 12 : 31 days

        $month = [
            '1' => 31,
            '2' => now()->year() % 4 == 0 ? 29 : 28,
            '3' => 31,
            '4' => 30,
            '5' => 31,
            '6' => 30,
            '7' => 31,
            '8' => 31,
            '9' => 30,
            '10' => 31,
            '11' => 30,
            '12' => 31,
        ];
    }
}
