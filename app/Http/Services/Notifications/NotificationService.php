<?php

namespace App\Http\Services\Notifications;

use App\Models\Notifications\Notification;
use App\Models\Users\ChildrenGuardian;
use App\Models\Users\Patient;
use App\Models\Users\User;
use App\Services\FilterService;
use App\Services\FirebaseService;
use App\Services\MessageService;

class NotificationService
{
    public function index($data)
    {
        $query = Notification::query();

        $searchFields = ['message', 'type'];
        $numericFields = [];
        $dateFields = ['read_at', 'created_at'];
        $exactMatchFields = ['id', 'type', 'read_at'];
        $inFields = ['type'];


        $user = User::auth();


        $query->where('user_id', $user->id);


        return FilterService::applyFilters(
            $query,
            $data,
            $searchFields,
            $numericFields,
            $dateFields,
            $exactMatchFields,
            $inFields
        );
    }

    public function show($id)
    {
        $notification = Notification::with('user')->find($id);

        if (!$notification) {
            MessageService::abort(404, 'الإشعار غير موجود');
        }

        return $notification;
    }

    public function create($validatedData)
    {
        return Notification::create($validatedData);
    }

    public function update($notification, $validatedData)
    {
        $notification->update($validatedData);

        return $notification;
    }

    public function readNotification($id)
    {
        $notifications = Notification::where('id', '<=', $id)->get();

        foreach ($notifications as $notification) {
            $notification->update(['read_at' => now()]);
        }

        return $notifications;
    }

    public function destroy($notification)
    {
        return $notification->delete();
    }



    public static function storeNotification($users_ids, $notificationable, $type, $title, $body, $data = [])
    {

        foreach ($users_ids as $user_id) {
            $notificationData = [
                'user_id' => $user_id,
                'title' => $title,
                'message' => $body,
                'type' => $type,
                'notificationable_id' => $notificationable['id'] ?? null,
                'notificationable_type' => $notificationable['type'] ?? 'Custom',
                'metadata' => [
                    'data' => $data,
                    'notificationable' => $notificationable,
                ],
            ];

            Notification::create($notificationData);
        }
    }

    //sendEmergencyNotification
    public static function sendEmergencyNotification($data)
    {
        $user = User::auth();

        $patient = $user->patient;

        $guardian = ChildrenGuardian::where('patient_id', $patient->id)->first()->guardian;

        FirebaseService::sendToTopicAndStorage(
            'user-' . $guardian->user_id,
            [
                $guardian->user_id,
            ],
            [
                'id' => $patient->id,
                'type' => Patient::class,
            ],
            $data['title'],
            $data['message'],
            'emergency',
        );
    }
}
