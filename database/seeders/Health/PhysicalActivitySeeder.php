<?php

namespace Database\Seeders;

use App\Models\Health\PhysicalActivity;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PhysicalActivitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create 15 physical activities for 3 patients:1,2,3
        $patients = [1, 2, 3];
        $activities = [
            ['activity_date' => '2025-03-01', 'activity_time' => '6-8', 'description' => 'جري صباحي', 'intensity' => 'moderate', 'duration' => 30, 'notes' => 'شعرت بالراحة'],
            ['activity_date' => '2025-03-02', 'activity_time' => '8-10', 'description' => 'جلسة يوغا', 'intensity' => 'low', 'duration' => 60, 'notes' => 'مريح'],
            ['activity_date' => '2025-03-03', 'activity_time' => '10-12', 'description' => 'تمرين رفع أثقال', 'intensity' => 'high', 'duration' => 45, 'notes' => 'شعرت بالتعب'],
            ['activity_date' => '2025-03-04', 'activity_time' => '12-14', 'description' => 'سباحة', 'intensity' => 'moderate', 'duration' => 30, 'notes' => 'ممتع'],
            ['activity_date' => '2025-03-05', 'activity_time' => '14-16', 'description' => 'ركوب دراجة', 'intensity' => 'low', 'duration' => 60, 'notes' => 'مريح'],
            ['activity_date' => '2025-03-06', 'activity_time' => '16-18', 'description' => 'تمرين كارديو', 'intensity' => 'high', 'duration' => 30, 'notes' => 'شعرت بالتعب'],
            ['activity_date' => '2025-03-07', 'activity_time' => '18-20', 'description' => 'تمرين بيلاتس', 'intensity' => 'low', 'duration' => 45, 'notes' => 'مريح'],
            ['activity_date' => '2025-03-08', 'activity_time' => '20-22', 'description' => 'تمرين زومبا', 'intensity' => 'moderate', 'duration' => 60, 'notes' => 'ممتع'],
            // Add more activities as needed
        ];

        // $table->enum('intensity', ["low", "moderate", "high"]);


        foreach ($patients as $patient) {
            foreach ($activities as $activity) {
                PhysicalActivity::create(array_merge(
                    $activity,
                    [
                        'patient_id' => $patient,
                        'created_at' => now(),
                        'updated_at' => now()
                    ]
                ));
            }
        }
    }
}
