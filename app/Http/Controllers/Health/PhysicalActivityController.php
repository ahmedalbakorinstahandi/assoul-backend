<?php

namespace App\Http\Controllers\Health;

use App\Http\Controllers\Controller;
use App\Http\Requests\Health\PhysicalActivity\CreateRequest;
use App\Http\Requests\Health\PhysicalActivity\UpdateRequest;
use App\Http\Resources\Health\PhysicalActivityResource;
use App\Http\Services\Health\PhysicalActivityService;
use App\Services\ResponseService;
use Illuminate\Http\Request;

class PhysicalActivityController extends Controller
{
    protected $physicalActivityService;

    public function __construct(PhysicalActivityService $physicalActivityService)
    {
        $this->physicalActivityService = $physicalActivityService;
    }

    public function index(Request $request)
    {
        $activities = $this->physicalActivityService->index($request->all());

        return response()->json([
            'success' => true,
            'data' => PhysicalActivityResource::collection($activities->items()),
            'meta' => ResponseService::meta($activities),
        ], 200);
    }

    public function show($id)
    {
        $activity = $this->physicalActivityService->show($id);

        return response()->json([
            'success' => true,
            'data' => new PhysicalActivityResource($activity),
        ], 200);
    }

    public function create(CreateRequest $request)
    {
        $activity = $this->physicalActivityService->create($request->all());

        return response()->json([
            'success' => true,
            'data' => new PhysicalActivityResource($activity),
            'message' => 'تمت إضافة النشاط البدني بنجاح',
        ], 201);
    }

    public function update($id, UpdateRequest $request)
    {
        $activity = $this->physicalActivityService->show($id);
        
        $activity = $this->physicalActivityService->update($activity, $request->all());

        return response()->json([
            'success' => true,
            'data' => new PhysicalActivityResource($activity),
            'message' => 'تم تحديث النشاط البدني بنجاح',
        ], 200);
    }

    public function delete($id)
    {
        $activity = $this->physicalActivityService->show($id);

        $this->physicalActivityService->delete($activity);

        return response()->json([
            'success' => true,
            'message' => 'تم حذف النشاط البدني بنجاح',
        ], 200);
    }
}
