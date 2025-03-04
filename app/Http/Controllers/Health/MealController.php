<?php

namespace App\Http\Controllers\Health;

use App\Http\Controllers\Controller;
use App\Http\Requests\Health\Meal\CreateRequest;
use App\Http\Requests\Health\Meal\UpdateRequest;
use App\Http\Resources\Health\MealResource;
use App\Http\Services\Health\MealService;
use App\Services\ResponseService;
use Illuminate\Http\Request;

class MealController extends Controller
{
    protected $mealService;

    public function __construct(MealService $mealService)
    {
        $this->mealService = $mealService;
    }

    public function index(Request $request)
    {
        $meals = $this->mealService->index($request->all());

        return response()->json([
            'success' => true,
            'data' => MealResource::collection($meals->items()),
            'meta' => ResponseService::meta($meals),
        ], 200);
    }

    public function show($id)
    {
        $meal = $this->mealService->show($id);

        return response()->json([
            'success' => true,
            'data' => new MealResource($meal),
        ], 200);
    }

    public function create(CreateRequest $request)
    {
        $meal = $this->mealService->create($request->all());

        return response()->json([
            'success' => true,
            'data' => new MealResource($meal),
            'message' => 'تمت إضافة الوجبة بنجاح',
        ], 201);
    }

    public function update($id, UpdateRequest $request)
    {
        $meal = $this->mealService->show($id);

        $meal = $this->mealService->update($meal, $request->all());

        return response()->json([
            'success' => true,
            'data' => new MealResource($meal),
            'message' => 'تم تحديث بيانات الوجبة بنجاح',
        ], 200);
    }

    public function delete($id)
    {
        $meal = $this->mealService->show($id);

        $this->mealService->delete($meal);

        return response()->json([
            'success' => true,
            'message' => 'تم حذف الوجبة بنجاح',
        ], 200);
    }
}
