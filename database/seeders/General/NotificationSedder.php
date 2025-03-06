<?php

namespace Database\Seeders\General;

use App\Models\Notifications\Notification;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Carbon\Carbon;

class NotificationSedder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // create 15 notifications for 3 users 1, 2, 3  in arabic
        $users = [1, 2, 3];
        $titles = ['إشعار جديد', 'تنبيه هام', 'رسالة جديدة'];
        $messages = [
            'لديك إشعار جديد في حسابك.',
            'يرجى مراجعة التنبيه الهام في حسابك.',
            'لقد تلقيت رسالة جديدة.'
        ];

        foreach ($users as $user) {
            for ($i = 0; $i < 5; $i++) {
                Notification::create([
                    'user_id' => $user,
                    'title' => $titles[array_rand($titles)],
                    'message' => $messages[array_rand($messages)],
                    'type' => 'info',
                    'read_at' => null,
                    'metadata' => json_encode(['key' => 'value']),
                    'notifiable_id' => $user,
                    'notifiable_type' => 'App\Models\User',
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ]);
            }
        }
    }
}
