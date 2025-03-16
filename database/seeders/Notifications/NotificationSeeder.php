<?php

namespace Database\Seeders\Notifications;

use App\Models\Notifications\Notification;
use App\Models\Users\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class NotificationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // create 10 notifications for each user

        $faker = Faker::create();

        $users = User::all();

        foreach ($users as $user) {
            for ($i = 0; $i < 10; $i++) {
                Notification::create([
                    'user_id' => $user->id,
                    'title' => $faker->sentence,
                    'message' => $faker->paragraph,
                    'type' => $faker->randomElement(['info', 'warning', 'alert']),
                    'metadata' => ['key' => $faker->word],
                    'notifiable_type' => User::class,
                    'notifiable_id' => $user->id,
                ]);
            }
        }
    }
}
