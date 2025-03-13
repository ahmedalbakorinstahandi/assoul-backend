<?php

namespace Database\Seeders\Users;

use App\Models\Users\ChildrenGuardian;
use App\Models\Users\Guardian;
use App\Models\Users\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class GuardianSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user1 = User::create([
            'first_name' => 'ahmed',
            'last_name' => 'albakor',
            'email' => 'guardian1@gmail.com',
            'role' => 'guardian',
            'phone' => '1234567890',
            'password' => bcrypt('password'),
            'otp' => null,
            'otp_expide_at' => null,
            'verified' => true,
            'avatar' => null,
            'status' => 'Active',
        ]);

        $guardian1 =  Guardian::create([
            'user_id' => $user1->id,
        ]);

        // user guardian 2
        $user2 = User::create(
            [
                'first_name' => 'mohamed',
                'last_name' => 'albakor',
                'email' => 'guardian2@gmail.com',
                'role' => 'guardian',
                'phone' => '1234567890',
                'password' => bcrypt('password'),
                'otp' => null,
                'otp_expide_at' => null,
                'verified' => true,
                'avatar' => null,
                'status' => 'Active',
            ]
        );

        $guardian2 =  Guardian::create([
            'user_id' => $user2->id,
        ]);


        ChildrenGuardian::create([
            'guardian_id' => $guardian1->id,
            'patient_id' => 1,
        ]);

        ChildrenGuardian::create([
            'guardian_id' => $guardian1->id,
            'patient_id' => 2,
        ]);

        ChildrenGuardian::create([
            'guardian_id' => $guardian2->id,
            'patient_id' => 3,
        ]);
    }
}
