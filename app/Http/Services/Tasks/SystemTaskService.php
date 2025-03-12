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
        $dateFields = ['completed_at'];


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

        $status =  $data['status'];
        $patient = User::auth()->patient;

        $completedAt = Carbon::parse($data['completed_at'])->toDateString();

        $systemTaskCompletion = SystemTaskCompletion::where('task_id', $task->id)
            ->where('patient_id', $patient->id)
            ->whereDate('completed_at', $completedAt)
            ->first();

        if ($status == 'completed') {
            if ($systemTaskCompletion) {
                return $systemTaskCompletion->status;
            }
            $systemTaskCompletion = SystemTaskCompletion::create([
                'patient_id' => $patient->id,
                'task_id' => $task->id,
                'completed_at' => $data['completed_at'],
            ]);

            $patient->points += $task->points;
            $patient->save();

            return $systemTaskCompletion->status;
        }
        if ($status == 'not_completed') {
            if ($systemTaskCompletion) {
                $systemTaskCompletion->delete();

                $patient->points -= $task->points;
                $patient->save();

                return false;
            }

            return false;
        }

        return $task;
    }
}
