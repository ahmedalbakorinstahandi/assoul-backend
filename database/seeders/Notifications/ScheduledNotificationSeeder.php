<?php

namespace Database\Seeders\Notifications;

use App\Models\Notifications\ScheduledNotification;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ScheduledNotificationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'title' => 'إشعار صباحي',
                'content' => 'صباح الخير! لا تنسى تقيس مستوى السكر في الدم قبل الفطور.',
                'image' => null,
                'type' => 'daily',
                'month' => null,
                'week' => null,
                'day' => 1,
                'time' => '07:00',
                'status' => 'active',
            ],
            [
                'title' => 'إشعار منتصف الصباح ',
                'content' => 'تذكير: حان وقت قياس مستوى السكر في الدم بعد الفطور.',
                'image' => null,
                'type' => 'daily',
                'month' => null,
                'week' => null,
                'day' => 1,
                'time' => '10:00',
                'status' => 'active',
            ],
            [
                'title' => 'إشعار قبل الظهر ',
                'content' => 'تذكير: حان وقت النشاط البدني الخفيف وقياس مستوى السكر.',
                'image' => null,
                'type' => 'daily',
                'month' => null,
                'week' => null,
                'day' => 1,
                'time' => '12:00',
                'status' => 'active',
            ],
            [
                'title' => 'إشعار الظهر ',
                'content' => 'تذكير: حان وقت الغداء وقياس مستوى السكر في الدم.',
                'image' => null,
                'type' => 'daily',
                'month' => null,
                'week' => null,
                'day' => 1,
                'time' => '14:00',
                'status' => 'active',
            ],
            [
                'title' => 'إشعار بعد الظهر ',
                'content' => 'تذكير: حان وقت النشاط البدني وقياس مستوى السكر في الدم.',
                'image' => null,
                'type' => 'daily',
                'month' => null,
                'week' => null,
                'day' => 1,
                'time' => '16:00',
                'status' => 'active',
            ],
            [
                'title' => 'إشعار المغرب ',
                'content' => 'تذكير: حان وقت العشاء وقياس مستوى السكر في الدم.',
                'image' => null,
                'type' => 'daily',
                'month' => null,
                'week' => null,
                'day' => 1,
                'time' => '19:00',
                'status' => 'active',
            ],
            [
                'title' => 'إشعار قبل النوم ',
                'content' => 'تذكير: حان وقت قياس مستوى السكر في الدم قبل النوم.',
                'image' => null,
                'type' => 'daily',
                'month' => null,
                'week' => null,
                'day' => 1,
                'time' => '21:00',
                'status' => 'active',
            ],
            [
                'title' => 'إشعار أسبوعي ',
                'content' => 'تذكير: حان وقت زيارة الطبيب الأسبوعية وقياس مستوى السكر في الدم.',
                'image' => null,
                'type' => 'weekly',
                'month' => null,
                'week' => 1,
                'day' => 7,
                'time' => '09:00',
                'status' => 'active',
            ],
            [
                'title' => 'إشعار شهري ',
                'content' => 'تذكير: حان وقت متابعة النظام الغذائي الشهري وقياس مستوى السكر في الدم.',
                'image' => null,
                'type' => 'monthly',
                'month' => 1,
                'week' => null,
                'day' => 1,
                'time' => '09:00',
                'status' => 'active',
            ],
            [
                'title' => 'إشعار سنوي ',
                'content' => 'تذكير: حان وقت الفحص السنوي الشامل وقياس مستوى السكر في الدم.',
                'image' => null,
                'type' => 'yearly',
                'month' => 1,
                'week' => null,
                'day' => 1,
                'time' => '09:00',
                'status' => 'active',
            ],
        ];

        foreach ($data as $notification) {
            $notification['created_at'] = now();
            $notification['updated_at'] = now();
            ScheduledNotification::create($notification);
        }
    }
}
