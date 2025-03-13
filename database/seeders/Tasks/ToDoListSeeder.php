<?php

namespace Database\Seeders\Tasks;

use App\Models\Tasks\ToDoList;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ToDoListSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        // we have 3 patient 
        // and 2 guardian 
        //patient  1,2 for guardian 1 ,
        // patient 3  for guardian 2
        $patients = [
            1 => [1, 2],
            2 => [3]
        ];

        $tasks = [
            'قياس ضغط الدم',
            'تناول الدواء',
            'مراجعة الطبيب',
            'إجراء التحاليل',
            'تمارين رياضية',
            'تناول وجبة صحية',
            'الراحة والنوم',
            'متابعة السكر',
            'جلسة علاج طبيعي',
            'زيارة الأهل'
        ];

        foreach ($patients as $guardianId => $patientIds) {
            foreach ($patientIds as $patientId) {
                foreach ($tasks as $task) {
                    ToDoList::create([
                        'title' => $task,
                        'patient_id' => $patientId,
                        'assigned_by' => $guardianId
                    ]);
                }
            }
        }
    }
}
