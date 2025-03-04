<?php

namespace App\Http\Controllers\Health;

use App\Http\Controllers\Controller;
use App\Http\Requests\Health\BloodSugarReading\CreateRequest;
use App\Http\Requests\Health\BloodSugarReading\UpdateRequest;
use App\Http\Resources\Health\BloodSugarReadingResource;
use App\Http\Services\Health\BloodSugarReadingService;
use App\Services\ResponseService;
use Illuminate\Http\Request;

class BloodSugarReadingController extends Controller
{
    protected $bloodSugarReadingService;

    public function __construct(BloodSugarReadingService $bloodSugarReadingService)
    {
        $this->bloodSugarReadingService = $bloodSugarReadingService;
    }

    public function index(Request $request)
    {
        $bloodSugarReadings = $this->bloodSugarReadingService->index($request->all());

        return response()->json(
            [
                'success' => true,
                'data' => BloodSugarReadingResource::collection($bloodSugarReadings->items()),
                'meta' => ResponseService::meta($bloodSugarReadings),
            ],
            200
        );
    }

    public function show($id)
    {
        $bloodSugarReading = $this->bloodSugarReadingService->show($id);

        return response()->json(
            [
                'success' => true,
                'data' => new BloodSugarReadingResource($bloodSugarReading),
            ],
            200
        );
    }


    public function create(CreateRequest $request)
    {
        $bloodSugarReading = $this->bloodSugarReadingService->create($request->all());

        return response()->json(
            [
                'success' => true,
                'data' => new BloodSugarReadingResource($bloodSugarReading),
                'message' => 'تم اضافة قراءة سكر الدم بنجاح',
            ],
            201
        );
    }

    public function update($id, UpdateRequest $request)
    {
        $bloodSugarReading = $this->bloodSugarReadingService->show($id);

        $bloodSugarReading = $this->bloodSugarReadingService->update($bloodSugarReading, $request->all());

        return response()->json(
            [
                'success' => true,
                'data' => new BloodSugarReadingResource($bloodSugarReading),
                'message' => 'تم تحديث قراءة سكر الدم بنجاح',
            ],
            200
        );
    }

    public function delete($id)
    {
        $bloodSugarReading = $this->bloodSugarReadingService->show($id);

        $this->bloodSugarReadingService->delete($bloodSugarReading);

        return response()->json(
            [
                'success' => true,
                'message' => 'تم حذف قراءة سكر الدم بنجاح',
            ],
            200
        );
    }
}
