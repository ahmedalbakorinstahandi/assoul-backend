<?php

namespace App\Http\Controllers\Tasks;

use App\Http\Controllers\Controller;
use App\Http\Requests\Tasks\SystemTask\CreateRequest;
use App\Http\Requests\Tasks\SystemTask\TaskStatusRequest;
use App\Http\Requests\Tasks\SystemTask\UpdateRequest;
use App\Http\Resources\Tasks\SystemTaskResource;
use App\Http\Services\Tasks\SystemTaskService;
use App\Services\ResponseService;
use Illuminate\Http\Request;

class SystemTaskController extends Controller
{
    protected $systemTaskService;

    public function __construct(SystemTaskService $systemTaskService)
    {
        $this->systemTaskService = $systemTaskService;
    }

    public function index(Request $request)
    {
        $tasks = $this->systemTaskService->index($request->all());

        return response()->json([
            'success' => true,
            'data' => SystemTaskResource::collection($tasks->items()),
            'meta' => ResponseService::meta($tasks),
        ]);
    }

    public function show($id)
    {
        $task = $this->systemTaskService->show($id);

        return response()->json([
            'success' => true,
            'data' => new SystemTaskResource($task),
        ]);
    }

    public function create(CreateRequest $request)
    {
        $task = $this->systemTaskService->create($request->validated());

        return response()->json([
            'success' => true,
            'data' => new SystemTaskResource($task),
            'message' => 'تم إنشاء المهمة بنجاح',
        ]);
    }

    public function update(UpdateRequest $request, $id)
    {
        $task = $this->systemTaskService->show($id);

        $task = $this->systemTaskService->update($task, $request->validated());

        return response()->json([
            'success' => true,
            'data' => new SystemTaskResource($task),
            'message' => 'تم تحديث المهمة بنجاح',
        ]);
    }

    public function delete($id)
    {
        $task = $this->systemTaskService->show($id);

        $this->systemTaskService->delete($task);

        return response()->json([
            'success' => true,
            'message' => 'تم حذف المهمة بنجاح',
        ]);
    }

    public function taskStatus($id, TaskStatusRequest $request)
    {
        $task = $this->systemTaskService->show($id);

        $task =  $this->systemTaskService->taskStatus($task, $request->validated());

        return response()->json([
            'success' => true,
            'data' => new SystemTaskResource($task),
            'message' => 'تم تحديث حالة المهمة بنجاح',
        ]);
    }
}
