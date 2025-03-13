<?php

namespace App\Http\Services\Tasks;

use App\Services\MessageService;
use App\Http\Permissions\Tasks\ToDoListPermission;
use App\Models\Tasks\ToDoList;
use App\Models\Tasks\ToDoListCompletion;
use App\Models\Users\User;
use App\Services\FilterService;
use Carbon\Carbon;

class ToDoListService
{
    public function index($data)
    {
        $query = ToDoList::query();

        $searchFields = ['title'];
        $exactMatchFields = ['patient_id', 'assigned_by'];
        $dateFields = ['created_at'];

        $query = ToDoListPermission::index($query);


        $user = User::auth();

        if ($user->isPatient()) {
            $query->load('completion');
        }

        return FilterService::applyFilters(
            $query,
            $data,
            $searchFields,
            [],
            $dateFields,
            $exactMatchFields
        );
    }

    public function show($id)
    {
        $task = ToDoList::find($id);

        if (!$task) {
            MessageService::abort(404, 'المهمة غير موجودة');
        }

        ToDoListPermission::show($task);

        $user = User::auth();
        if ($user->isPatient()) {
            $task->load('completion');
        }

        return $task;
    }

    public function create($data)
    {
        $data = ToDoListPermission::create($data);

        $task = ToDoList::create($data);

        $user = User::auth();
        if ($user->isPatient()) {
            $task->load('completion');
        }

        return $task;
    }

    public function update(ToDoList $task, $data)
    {
        ToDoListPermission::update($task);

        $task->update($data);

        $user = User::auth();
        if ($user->isPatient()) {
            $task->load('completion');
        }

        return $task;
    }

    public function delete(ToDoList $task)
    {
        ToDoListPermission::delete($task);

        return $task->delete();
    }

    public function check($task, $data)
    {

        ToDoListPermission::check($task);

        $status =  $data['status'];
        $patient = User::auth()->patient;

        $createdAt = Carbon::parse($data['completed_at'])->toDateString();

        $taskCompletion = ToDoListCompletion::where('task_id', $task->id)
            ->where('patient_id', $patient->id)
            ->whereDate('completed_at', $createdAt)
            ->first();

        if ($status == 'completed' && !$taskCompletion) {
            ToDoListCompletion::create([
                'patient_id' => $patient->id,
                'task_id' => $task->id,
                'completed_at' => $data['completed_at'],
            ]);

            $patient->save();
        }
        if ($status == 'not_completed' && $taskCompletion) {

            $taskCompletion->delete();
        }

        $task->load('completion');

        return $task;
    }
}
