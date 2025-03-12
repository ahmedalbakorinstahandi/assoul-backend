<?php

namespace App\Http\Services\Tasks;

use App\Services\MessageService;
use App\Http\Permissions\Tasks\SystemTaskPermission;
use App\Models\Tasks\SystemTask;
use App\Models\Tasks\SystemTaskCompletion;
use App\Models\Users\User;
use App\Services\FilterService;
use Carbon\Carbon;
use Illuminate\Container\Attributes\Auth;

class SystemTaskService
{
    public function index($data)
    {
        $query = SystemTask::query()->with('systemTaskCompletion');

        $searchFields = ['title', 'description'];
        $numericFields = ['points'];
        $exactMatchFields = ['unique_key'];
        $dateFields = ['created_at'];


        return FilterService::applyFilters(
            $query,
            $data,
            $searchFields,
            $numericFields,
            $dateFields,
            $exactMatchFields
        );
    }

    public function show($id)
    {
        $task = SystemTask::find($id);

        if (!$task) {
            MessageService::abort(404, 'المهمة غير موجودة');
        }

        $task->load('systemTaskCompletion');

        return $task;
    }

    public function create($data)
    {
        $task = SystemTask::create($data);

        $task->load('systemTaskCompletion');

        return  $task;
    }

    public function update(SystemTask $task, $data)
    {

        $task->update($data);

        $task->load('systemTaskCompletion');

        return $task;
    }

    public function delete(SystemTask $task)
    {

        return $task->delete();
    }

    public function taskStatus($task, $data)
    {
        // if (!$task || !isset($data['status']) || !isset($data['created_at'])) {
        //     throw new \Exception("Invalid input: Task, status, or created_at is missing.");
        // }
    
        $status = $data['status'];
        $patient = User::auth()->patient;
        $createdAt = Carbon::parse($data['created_at'])->toDateString(); // تأكد من أن التاريخ صحيح
    
        // جلب سجل الإكمال إذا كان موجودًا
        $systemTaskCompletion = SystemTaskCompletion::where('task_id', $task->id)
            ->where('patient_id', $patient->id)
            ->whereDate('created_at', $createdAt)
            ->first();
    
        if ($status == 'completed' && !$systemTaskCompletion) {
            SystemTaskCompletion::updateOrCreate(
                [
                    'task_id' => $task->id,
                    'patient_id' => $patient->id,
                    'created_at' => $createdAt
                ],
                ['updated_at' => now()] // تحديث وقت التعديل فقط
            );
    
            $patient->increment('points', $task->points);
        } elseif ($status == 'not_completed' && $systemTaskCompletion) {
            $systemTaskCompletion->delete();
            $patient->decrement('points', $task->points);
        }
    
        return $task->load('systemTaskCompletion'); // جلب العلاقة بعد التحديث
    }
}
