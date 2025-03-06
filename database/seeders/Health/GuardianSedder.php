<?php

namespace Database\Seeders\Health;

use App\Models\Users\ChildrenGuardian;
use App\Models\Users\Guardian;
use App\Models\Users\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class GuardianSedder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user1 = User::create(
            [
                'first_name' => 'John',
                'last_name' => 'Doe',
                'email' => 'john.doe@example.com',
                'role' => 'guardian',
                'phone' => '1234567890',
                'password' => bcrypt('password'),
                'otp' => null,
                'otp_expide_at' => null,
                'verified' => true,
                'avatar' => null,
                'status' => 'Active',
                'remember_token' => null,
                'created_at' => now(),
                'updated_at' => now(),
                'deleted_at' => null,
            ],
        );


        $guardian1 = Guardian::create([
            'user_id' => $user1->id,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        ChildrenGuardian::create([
            'guardian_id' => $guardian1->id,
            'patient_id' => 1,
            'created_at' => now(),
            'updated_at' => now(),
        ]);


        ChildrenGuardian::create([
            'guardian_id' => $guardian1->id,
            'patient_id' => 2,
            'created_at' => now(),
            'updated_at' => now(),
        ]);


        $user2 = User::create(
            [
                'first_name' => 'Jane',
                'last_name' => 'Smith',
                'email' => 'jane.smith@example.com',
                'role' => 'guardian',
                'phone' => '0987654321',
                'password' => bcrypt('password'),
                'otp' => null,
                'otp_expide_at' => null,
                'verified' => true,
                'avatar' => null,
                'status' => 'Active',
                'remember_token' => null,
                'created_at' => now(),
                'updated_at' => now(),
                'deleted_at' => null,
            ],
        );

        $guardian2 = Guardian::create([
            'user_id' => $user2->id,
            'created_at' => now(),
            'updated_at' => now(),
        ]);


        ChildrenGuardian::create([
            'guardian_id' => $guardian2->id,
            'patient_id' => 3,
            'created_at' => now(),
            'updated_at' => now(),
        ]);


        $user3 = User::create(
            [
                'first_name' => 'Alice',
                'last_name' => 'Johnson',
                'email' => 'alice.johnson@example.com',
                'role' => 'guardian',
                'phone' => '1122334455',
                'password' => bcrypt('password'),
                'otp' => null,
                'otp_expide_at' => null,
                'verified' => true,
                'avatar' => null,
                'status' => 'Active',
                'remember_token' => null,
                'created_at' => now(),
                'updated_at' => now(),
                'deleted_at' => null,
            ],
        );


        $guardian3 = Guardian::create([
            'user_id' => $user3->id,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
