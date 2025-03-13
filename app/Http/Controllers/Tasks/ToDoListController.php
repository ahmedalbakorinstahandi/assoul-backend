<?php

namespace App\Http\Controllers\Tasks;

use App\Http\Controllers\Controller;
use App\Http\Requests\Tasks\ToDoList\CreateRequest;
use App\Http\Requests\Tasks\ToDoList\UpdateRequest;
use App\Http\Resources\Tasks\ToDoListResource;
use App\Http\Services\Tasks\ToDoListService;
use App\Services\ResponseService;
use Illuminate\Http\Request;

class ToDoListController extends Controller
{
    protected $toDoListService;

    public function __construct(ToDoListService $toDoListService)
    {
        $this->toDoListService = $toDoListService;
    }

    public function index(Request $request)
    {
        $tasks = $this->toDoListService->index($request->all());

        return response()->json([
            'success' => true,
            'data' => ToDoListResource::collection($tasks->items()),
            'meta' => ResponseService::meta($tasks),
        ]);
    }

    public function show($id)
    {
        $task = $this->toDoListService->show($id);

        return response()->json([
            'success' => true,
            'data' => new ToDoListResource($task),
        ]);
    }

    public function create(CreateRequest $request)
    {
        $task = $this->toDoListService->create($request->validated());

        return response()->json([
            'success' => true,
            'data' => new ToDoListResource($task),
            'message' => 'تم إنشاء المهمة بنجاح',
        ]);
    }

    public function update(UpdateRequest $request, $id)
    {
        $task = $this->toDoListService->show($id);

        $task = $this->toDoListService->update($task, $request->validated());

        return response()->json([
            'success' => true,
            'data' => new ToDoListResource($task),
            'message' => 'تم تحديث المهمة بنجاح',
        ]);
    }

    public function delete($id)
    {
        $task = $this->toDoListService->show($id);

        $this->toDoListService->delete($task);

        return response()->json([
            'success' => true,
            'message' => 'تم حذف المهمة بنجاح',
        ]);
    }
}
