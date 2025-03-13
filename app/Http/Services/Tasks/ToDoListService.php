<?php

namespace App\Http\Services\Tasks;

use App\Services\MessageService;
use App\Http\Permissions\Tasks\ToDoListPermission;
use App\Models\Tasks\ToDoList;
use App\Services\FilterService;

class ToDoListService
{
    public function index($data)
    {
        $query = ToDoList::query();

        $searchFields = ['title'];
        $exactMatchFields = ['patient_id', 'assigned_by'];
        $dateFields = ['created_at'];

        $query = ToDoListPermission::index($query);

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

        return $task;
    }

    public function create($data)
    {
        $data = ToDoListPermission::create($data);

        return ToDoList::create($data);
    }

    public function update(ToDoList $task, $data)
    {
        ToDoListPermission::update($task);

        $task->update($data);

        return $task;
    }

    public function delete(ToDoList $task)
    {
        ToDoListPermission::delete($task);

        return $task->delete();
    }
}
