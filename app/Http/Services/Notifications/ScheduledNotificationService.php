<?php

namespace App\Http\Services\Notifications;

use App\Models\Notifications\ScheduledNotification;
use App\Services\FilterService;
use App\Services\MessageService;

class ScheduledNotificationService
{
    public function index($data)
    {
        $qusery = ScheduledNotification::query();

        $searchFields = ['title', 'content'];
        $numericFields = ['month', 'week', 'day'];
        $dateFields = ['created_at', 'updated_at'];
        $exactMatchFields = ['type', 'status'];
        $inFields = ['type', 'status'];


        $qusery = FilterService::applyFilters(
            $qusery,
            $data,
            $searchFields,
            $numericFields,
            $dateFields,
            $exactMatchFields,
            $inFields
        );

        return $qusery;
    }

    public function show($id)
    {
        $scheduledNotification =  ScheduledNotification::find($id);

        if (!$scheduledNotification) {
            MessageService::abort(404, 'الإشعار المجدول غير موجود');
        }

        return $scheduledNotification;
    }

    public function create($data)
    {
        $scheduledNotification = ScheduledNotification::create($data);

        return $scheduledNotification;
    }

    public function update($scheduledNotification, $data)
    {
        $scheduledNotification->update($data);

        return $scheduledNotification;
    }

    public function destroy($scheduledNotification)
    {
        $scheduledNotification->delete();
    }
}
