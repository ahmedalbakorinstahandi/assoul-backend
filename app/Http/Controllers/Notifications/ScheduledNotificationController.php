<?php

namespace App\Http\Controllers\Notifications;

use App\Http\Controllers\Controller;
use App\Http\Requests\Notifications\ScheduledNotification\CreateRequest;
use App\Http\Resources\Notifications\ScheduledNotificationResource;
use App\Http\Services\Notifications\ScheduledNotificationService;
use App\Services\ResponseService;

class ScheduledNotificationController extends Controller
{
    protected $scheduledNotificationService;

    public function __construct(ScheduledNotificationService $scheduledNotificationService)
    {
        $this->scheduledNotificationService = $scheduledNotificationService;
    }

    public function index()
    {
        $scheduledNotifications = $this->scheduledNotificationService->index(request()->all());

        return response()->json(
            [
                'success' => true,
                'data' => ScheduledNotificationResource::collection($scheduledNotifications),
                'meta' => ResponseService::meta($scheduledNotifications),
            ]
        );
    }

    public function show($id)
    {
        $scheduledNotification = $this->scheduledNotificationService->show($id);

        return response()->json(
            [
                'success' => true,
                'data' => new ScheduledNotificationResource($scheduledNotification),
            ]
        );
    }

    public function create(CreateRequest $request)
    {
        $scheduledNotification = $this->scheduledNotificationService->create($request->validated());

        return response()->json(
            [
                'success' => true,
                'data' => new ScheduledNotificationResource($scheduledNotification),
                'message' => 'تم إنشاء الإشعار المجدول بنجاح',
            ],
        );
    }

    public function update(CreateRequest $request, $id)
    {
        $scheduledNotification = $this->scheduledNotificationService->show($id);

        $scheduledNotification = $this->scheduledNotificationService->update($scheduledNotification, $request->validated());

        return response()->json(
            [
                'success' => true,
                'data' => new ScheduledNotificationResource($scheduledNotification),
                'message' => 'تم تعديل الإشعار المجدول بنجاح',
            ]
        );
    }

    public function destroy($id)
    {
        $scheduledNotification = $this->scheduledNotificationService->show($id);

        $this->scheduledNotificationService->destroy($scheduledNotification);

        return response()->json(
            [
                'success' => true,
                'message' => 'تم حذف الإشعار المجدول بنجاح',
            ]
        );
    }
}
