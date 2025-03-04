<?php

namespace App\Http\Controllers\Health;

use App\Http\Controllers\Controller;
use App\Http\Requests\Health\InsulinDose\CreateRequest;
use App\Http\Requests\Health\InsulinDose\UpdateRequest;
use App\Http\Resources\Health\InsulinDoseResource;
use App\Http\Services\Health\InsulinDoseService;
use App\Services\ResponseService;
use Illuminate\Http\Request;

class InsulinDoseController extends Controller
{
    protected $insulinDoseService;

    public function __construct(InsulinDoseService $insulinDoseService)
    {
        $this->insulinDoseService = $insulinDoseService;
    }

    public function index(Request $request)
    {
        $insulinDoses = $this->insulinDoseService->index($request->all());

        return response()->json([
            'success' => true,
            'data' => InsulinDoseResource::collection($insulinDoses->items()),
            'meta' => ResponseService::meta($insulinDoses),
        ], 200);
    }

    public function show($id)
    {
        $insulinDose = $this->insulinDoseService->show($id);

        return response()->json([
            'success' => true,
            'data' => new InsulinDoseResource($insulinDose),
        ], 200);
    }

    public function create(CreateRequest $request)
    {
        $insulinDose = $this->insulinDoseService->create($request->all());

        return response()->json([
            'success' => true,
            'data' => new InsulinDoseResource($insulinDose),
            'message' => 'تمت إضافة جرعة الأنسولين بنجاح',
        ], 201);
    }

    public function update($id, UpdateRequest $request)
    {
        $insulinDose = $this->insulinDoseService->show($id);

        $insulinDose = $this->insulinDoseService->update($insulinDose, $request->all());

        return response()->json([
            'success' => true,
            'data' => new InsulinDoseResource($insulinDose),
            'message' => 'تم تحديث جرعة الأنسولين بنجاح',
        ], 200);
    }

    public function delete($id)
    {
        $insulinDose = $this->insulinDoseService->show($id);

        $this->insulinDoseService->delete($insulinDose);

        return response()->json([
            'success' => true,
            'message' => 'تم حذف جرعة الأنسولين بنجاح',
        ], 200);
    }
}
