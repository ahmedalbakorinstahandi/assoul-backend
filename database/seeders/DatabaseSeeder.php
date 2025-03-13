<?php

namespace Database\Seeders;

use App\Models\Tasks\ToDoList;
use App\Models\Users\User;
use Database\Seeders\Games\AnswerSeeder;
use Database\Seeders\Games\GameSeeder;
use Database\Seeders\Games\LevelSeeder;
use Database\Seeders\Games\QuestionSeeder;
use Database\Seeders\General\EducationalContentSeeder;
use Database\Seeders\General\NotificationSedder;
use Database\Seeders\Health\BloodSugarReadingSedder;
use Database\Seeders\Health\GuardianSedder;
use Database\Seeders\Health\InsulinDoseSedder;
use Database\Seeders\Health\MealSedder;
use Database\Seeders\Notifications\ScheduledNotificationSeeder;
use Database\Seeders\Tasks\SystemTaskSeeder;
use Database\Seeders\Tasks\ToDoListSeeder;
use Database\Seeders\Users\GuardianSeeder;
use Database\Seeders\Users\PatientSeeder;
use Database\Seeders\Users\UserSeeder;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run()
    {
        $this->call([
            //     PatientSeeder::class,
            //     GuardianSedder::class,
            //     BloodSugarReadingSedder::class,
            //     InsulinDoseSedder::class,
            //     MealSedder::class,
            //     NotificationSedder::class,
            //     PhysicalActivitySedder::class,
            // UserSeeder::class,
            // EducationalContentSeeder::class,
            // ScheduledNotificationSeeder::class,
            // SystemTaskSeeder::class,
            // GuardianSeeder::class,
            ToDoListSeeder::class,
        ]);

        $this->call([
            // GameSeeder::class,
            // LevelSeeder::class,
            // QuestionSeeder::class,
            // AnswerSeeder::class,
        ]);
    }
}
