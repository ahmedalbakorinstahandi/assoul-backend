<?php

namespace App\Http\Services\Tasks;

use App\Services\MessageService;
use App\Http\Permissions\Tasks\SystemTaskPermission;
use App\Models\Tasks\SystemTask;
use App\Services\FilterService;

class SystemTaskService
{
    public function index($data)
    {
        $query = SystemTask::query();

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


        return $task;
    }

    public function create($data)
    {

        return SystemTask::create($data);
    }

    public function update(SystemTask $task, $data)
    {

        $task->update($data);

        return $task;
    }

    public function delete(SystemTask $task)
    {

        return $task->delete();
    }
}
