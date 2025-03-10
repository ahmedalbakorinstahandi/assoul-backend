<?php

namespace Database\Seeders\Tasks;

use App\Models\Tasks\SystemTask;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SystemTaskSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
   
    public function run(): void
    { 
        // وجبة الفطور #D86B00 1.png  key: breakfast
        // شرب الماء #4D9598 2.png key: drink_water
        // جرعة الأنسولين #F8BC2A 3.png key: insulin_dose
        // تمارين الصباح #3C7413 4.png key: morning_exercise
        // وجبة الغداء #915032 5.png key: lunch
        // قياس السكر #0072A1 6.png key: measure_sugar 
        // تناول سناك #9E3749 7.png key: snack
        

        // create system tasks
        $data = [
            [
                'title' => 'وجبة الفطور',
                'color' => '#D86B00',
                'points' => 10,
                'image' => '1.png',
                'unique_key' => 'breakfast',
            ],
            [
                'title' => 'شرب الماء',
                'color' => '#4D9598',
                'points' => 5,
                'image' => '2.png',
                'unique_key' => 'drink_water',
            ],
            [
                'title' => 'جرعة الأنسولين',
                'color' => '#F8BC2A',
                'points' => 15,
                'image' => '3.png',
                'unique_key' => 'insulin_dose',
            ],
            [
                'title' => 'تمارين الصباح',
                'color' => '#3C7413',
                'points' => 20,
                'image' => '4.png',
                'unique_key' => 'morning_exercise',
            ],
            [
                'title' => 'وجبة الغداء',
                'color' => '#915032',
                'points' => 10,
                'image' => '5.png',
                'unique_key' => 'lunch',
            ],
            [
                'title' => 'قياس السكر',
                'color' => '#0072A1',
                'points' => 5,
                'image' => '6.png',
                'unique_key' => 'measure_sugar',
            ],
            [
                'title' => 'تناول سناك',
                'color' => '#9E3749',
                'points' => 5,
                'image' => '7.png',
                'unique_key' => 'snack',
            ],
        ];

        foreach ($data as $task) {
            $task['created_at'] = now();
            $task['updated_at'] = now();
            SystemTask::create($task);
        }
    }
}
