<?php

namespace Database\Seeders\General;

use App\Models\General\EducationalContent;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class EducationalContentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $contents = [
            [
                'title' => 'كيف تأخذ جرعة الانسولين',
                'link' => 'https://www.youtube.com/watch?v=3bbg79oEKuQ',
                'key' => 'insulin_dose',
                'duration' => 3,
                'is_visible' => true,
                'order' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'طريقة قياس نسبة السكر في الدم 💉',
                'link' => 'https://www.youtube.com/shorts/ntwVUybXX9o',
                'duration' => 2,
                'key' => 'blood_sugar_reading',
                'is_visible' => true,
                'order' => 2,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'نصائح للوقاية من مرض السكري',
                'link' => 'https://www.youtube.com/watch?v=KrhrqdOxu2A',
                'duration' => 4,
                'is_visible' => true,
                'order' => 3,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'السكري- الجلوكوز',
                'link' => 'https://www.youtube.com/watch?v=I-CzjjXPbKc',
                'duration' => 3,
                'is_visible' => true,
                'order' => 4,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'مرض السكري',
                'link' => 'https://www.youtube.com/shorts/ntwVUybXX9o',
                'duration' => 2,
                'is_visible' => true,
                'order' => 5,
                'created_at' => now(),
                'updated_at' => now(),
            ],

        ];

        foreach ($contents as $content) {
            EducationalContent::create($content);
        }
    }
}
