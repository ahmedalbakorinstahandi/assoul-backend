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
        $query = SystemTask::query();

        $searchFields = ['title', 'unique_key'];
        $numericFields = ['points'];
        $exactMatchFields = ['unique_key'];
        $dateFields = ['completed_at'];


        $user = User::auth();
        if (isset($data['patient_id']) || $user->isPatient()) {
            $query->with('systemTaskCompletion');
        }


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


        $user = User::auth();
        if (isset($data['patient_id']) || $user->isPatient()) {
            $task->load('systemTaskCompletion');
        }

        return $task;
    }

    public function create($data)
    {
        $task = SystemTask::create($data);

        $user = User::auth();
        if (isset($data['patient_id']) || $user->isPatient()) {
            $task->load('systemTaskCompletion');
        }

        return  $task;
    }

    public function update(SystemTask $task, $data)
    {

        $task->update($data);

        $user = User::auth();
        if (isset($data['patient_id']) || $user->isPatient()) {
            $task->load('systemTaskCompletion');
        }

        return $task;
    }

    public function delete(SystemTask $task)
    {

        return $task->delete();
    }

    public function taskStatus($task, $data)
    {

        $status =  $data['status'];
        $patient = User::auth()->patient;

        $createdAt = Carbon::parse($data['completed_at'])->toDateString();

        $systemTaskCompletion = SystemTaskCompletion::where('task_id', $task->id)
            ->where('patient_id', $patient->id)
            ->whereDate('completed_at', $createdAt)
            ->first();

        if ($status == 'completed' && !$systemTaskCompletion) {
            SystemTaskCompletion::create([
                'patient_id' => $patient->id,
                'task_id' => $task->id,
                'completed_at' => $data['completed_at'],
            ]);

            $patient->points += $task->points;
            $patient->save();
        }
        if ($status == 'not_completed' && $systemTaskCompletion) {

            $systemTaskCompletion->delete();

            $patient->points -= $task->points;
            $patient->save();
        }

        $task->load('systemTaskCompletion');

        return $task;
    }
}
