<?php

namespace Database\Seeders\Health;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Health\BloodSugarReading;
use Carbon\Carbon;

class BloodSugarReadingSedder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create 15 sugar readings for 3 patients:1,2,3
        $patients = [1, 2, 3];
        $measurementTypes = ["fasting", "befor_breakfast", "befor_lunch", "befor_dinner", "after_snack", "after_breakfast", "after_lunch", "after_dinner", "befor_activity", "after_activity"];
        $units = ["mg/dL", "mmol/L"];

        foreach ($patients as $patientId) {
            for ($i = 0; $i < 25; $i++) {
                BloodSugarReading::create([
                    'patient_id' => $patientId,
                    'measurement_type' => $measurementTypes[array_rand($measurementTypes)],
                    'value' => rand(70, 180) + rand() / getrandmax(),
                    'unit' => $units[array_rand($units)],
                    'notes' => 'Sample note ' . ($i + 1),
                    'measured_at' => Carbon::now()->subDays(rand(0, max: 10)),
                ]);
            }
        }
    }
}
