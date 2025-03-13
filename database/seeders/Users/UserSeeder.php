<?php

namespace Database\Seeders\Users;

use App\Models\Users\Guardian;
use App\Models\Users\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create 1 admin user
        User::create([
            'first_name' => 'Admin',
            'last_name' => 'User',
            'email' => 'admin@gmail.com',
            'role' => 'admin',
            'phone' => '1234567890',
            'password' => bcrypt('password'),
            'otp' => null,
            'otp_expide_at' => null,
            'verified' => true,
            'avatar' => null,
            'status' => 'Active',
        ]);
    }
}
