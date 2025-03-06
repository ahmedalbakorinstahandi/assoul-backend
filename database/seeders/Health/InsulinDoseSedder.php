<?php

namespace Database\Seeders\Health;

use App\Models\Health\InsulinDose;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class InsulinDoseSedder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create 25 insulin doses for 3 patients:1,2,3

        $patients = [1, 2, 3];
        $insulinTypes = ['NovoRapid', 'Humalog', 'Apidra', 'Levemir', 'Lantus', 'Toujeo', 'Tresiba'];
        $injectionSites = ['arm', 'thigh', 'abdomen', 'lower_back'];
        $takenTimes = ['befor_breakfast_2h', 'befor_lunch_2h', 'befor_dinner_2h'];

        foreach ($patients as $patient) {
            for ($i = 0; $i < 25; $i++) {
                InsulinDose::create([
                    'patient_id' => $patient,
                    'taken_date' => now()->subDays(rand(0, 5))->toDateString(),
                    'taken_time' => $takenTimes[array_rand($takenTimes)],
                    'insulin_type' => $insulinTypes[array_rand($insulinTypes)],
                    'dose_units' => rand(5, 50),
                    'injection_site' => $injectionSites[array_rand($injectionSites)],
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }
    }
}
