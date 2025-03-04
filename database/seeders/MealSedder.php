<?php

namespace Database\Seeders;

use App\Models\Health\Meal;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Carbon\Carbon;

class MealSedder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create 15 meals for 3 patients:1,2,3
        $patients = [1, 2, 3];
        $mealTypes = ["breakfast", "lunch", "dinner", "snack"];

        $descriptions = [
            'وجبة لذيذة وصحية',
            'وجبة خفيفة ومغذية',
            'وجبة غنية بالبروتينات',
            'وجبة متوازنة ومفيدة',
            'وجبة تحتوي على الفيتامينات'
        ];

        $notes = [
            'يجب تناولها ببطء',
            'تناولها مع كوب من الماء',
            'تناولها قبل التمرين',
            'تناولها بعد التمرين',
            'تناولها في الصباح'
        ];

        foreach ($patients as $patientId) {
            for ($i = 0; $i < 15; $i++) {
                Meal::create([
                    'patient_id' => $patientId,
                    'consumed_date' => Carbon::now()->subDays(rand(0, 5)),
                    'type' => $mealTypes[array_rand($mealTypes)],
                    'carbohydrates_calories' => rand(100, 500),
                    'description' => $descriptions[array_rand($descriptions)],
                    'notes' => $notes[array_rand($notes)],
                ]);
            }
        }
    }
}
