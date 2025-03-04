<?php

namespace Database\Seeders;

use App\Models\Users\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PatientSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        // Patient 1
        $user = User::create(
            [
                'first_name' => 'أحمد',
                'last_name' => 'محمد',
                'role' => 'patient',
                'password' => bcrypt('NONE_PASSWORD'),
                'otp' => '11111',
                'otp_expide_at' => now()->addDay(50),
                'verified' => true,
                'avatar' => null,
                'status' => 'Active',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        );


        $patient = $user->patient()->create(
            [
                'gender' => 'male',
                'birth_data' => '2015-01-01',
                'height' => 120.5,
                'weight' => 40.0,
                'insulin_doses' => 4,
                'points' => 1000,
                'diabetes_diagnosis_age' => 7,
                'created_at' => now(),
                'updated_at' => now(),
            ]
        );

        // Patient 2
        $user = User::create(
            [
                'first_name' => 'محمد',
                'last_name' => 'أحمد',
                'role' => 'patient',
                'password' => bcrypt('NONE_PASSWORD'),
                'otp' => '22222',
                'otp_expide_at' => now()->addDay(50),
                'verified' => true,
                'avatar' => null,
                'status' => 'Active',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        );


        $user->patient()->create(
            [
                'gender' => 'male',
                'birth_data' => '2018-05-15',
                'height' => 130.0,
                'weight' => 45.0,
                'insulin_doses' => 5,
                'points' => 1500,
                'diabetes_diagnosis_age' => 4,
                'created_at' => now(),
                'updated_at' => now(),
            ]
        );


        // Patient 3  , female , age : 12 

        $user = User::create(
            [
                'first_name' => 'سارة',
                'last_name' => 'محمد',
                'role' => 'patient',
                'password' => bcrypt('NONE_PASSWORD'),
                'otp' => '33333',
                'otp_expide_at' => now()->addDay(50),
                'verified' => true,
                'avatar' => null,
                'status' => 'Active',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        );


        $user->patient()->create(
            [
                'gender' => 'female',
                'birth_data' => '2013-03-22',
                'height' => 140.0,
                'weight' => 35.0,
                'insulin_doses' => 3,
                'points' => 1200,
                'diabetes_diagnosis_age' => 10,
                'created_at' => now(),
                'updated_at' => now(),
            ]
        );
    }
}
