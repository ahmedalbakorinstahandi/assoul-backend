<?php

namespace App\Http\Controllers\Notifications;

use App\Http\Controllers\Controller;
use App\Http\Requests\Notifications\Notification\CreateRequest;
use App\Http\Requests\Notifications\Notification\UpdateRequest;
use App\Http\Resources\Notifications\NotificationResource;
use App\Http\Services\Notifications\NotificationService;
use App\Models\Users\User;
use App\Services\ResponseService;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    protected $notificationService;

    public function __construct(NotificationService $notificationService)
    {
        $this->notificationService = $notificationService;
    }

    public function index()
    {
        $notifications = $this->notificationService->index(request()->all());

        return response()->json([
            'success' => true,
            'data' => NotificationResource::collection($notifications->items()),
            'meta' => ResponseService::meta($notifications),
        ]);
    }

    public function show($id)
    {
        $notification = $this->notificationService->show($id);

        return response()->json([
            'success' => true,
            'data' => new NotificationResource($notification),
        ]);
    }

    public function create(CreateRequest $request)
    {
        $notification = $this->notificationService->create($request->validated());

        return response()->json([
            'success' => true,
            'message' => trans('messages.item_created_successfully'),
            'data' => new NotificationResource($notification),
        ]);
    }

    public function update($id, UpdateRequest $request)
    {
        $notification = $this->notificationService->show($id);

        $notification = $this->notificationService->update($notification, $request->validated());

        return response()->json([
            'success' => true,
            'message' => trans('messages.item_updated_successfully'),
            'data' => new NotificationResource($notification),
        ]);
    }

    public function readNotification($id)
    {
        $notification = $this->notificationService->show($id);

        $notifications = $this->notificationService->readNotification($notification->id);

        return response()->json([
            'success' => true,
            'data' => NotificationResource::collection($notifications),
        ]);
    }

    public function destroy($id)
    {
        $notification = $this->notificationService->show($id);

        $deleted = $this->notificationService->destroy($notification);

        return response()->json([
            'success' => $deleted,
            'message' => $deleted
                ? trans('messages.item_deleted_successfully')
                : trans('messages.failed_delete_item'),
        ]);
    }


    public function getNotificationsUnreadCount()
    {
        $user = User::auth();
        $count = $user->notificationsUnreadCount();

        return response()->json([
            'success' => true,
            'data' => ['count' => $count],
        ]);
    }
}
