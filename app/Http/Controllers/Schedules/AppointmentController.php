<?php

namespace App\Http\Controllers\Schedules;

use App\Http\Controllers\Controller;
use App\Http\Requests\Schedules\Appointment\CreateRequest;
use App\Http\Requests\Schedules\Appointment\UpdateRequest;
use App\Http\Resources\Schedules\AppointmentResource;
use App\Http\Services\Schedules\AppointmentService;
use App\Services\ResponseService;
use Illuminate\Http\Request;

class AppointmentController extends Controller
{
    protected $appointmentService;

    public function __construct(AppointmentService $appointmentService)
    {
        $this->appointmentService = $appointmentService;
    }

    public function index(Request $request)
    {
        $appointments = $this->appointmentService->index($request->all());

        return response()->json([
            'success' => true,
            'data' => AppointmentResource::collection($appointments->items()),
            'meta' => ResponseService::meta($appointments),
        ]);
    }

    public function show($id)
    {
        $appointment = $this->appointmentService->show($id);

        return response()->json([
            'success' => true,
            'data' => new AppointmentResource($appointment),
        ]);
    }

    public function create(CreateRequest $request)
    {
        $appointment = $this->appointmentService->create($request->validated());

        return response()->json([
            'success' => true,
            'data' => new AppointmentResource($appointment),
            'message' => 'تم إنشاء الموعد بنجاح',
        ]);
    }

    public function update(UpdateRequest $request, $id)
    {
        $appointment = $this->appointmentService->show($id);

        $appointment = $this->appointmentService->update($appointment, $request->validated());

        return response()->json([
            'success' => true,
            'data' => new AppointmentResource($appointment),
            'message' => 'تم تحديث الموعد بنجاح',
        ]);
    }

    public function delete($id)
    {
        $appointment = $this->appointmentService->show($id);

        $this->appointmentService->delete($appointment);

        return response()->json([
            'success' => true,
            'message' => 'تم حذف الموعد بنجاح',
        ]);
    }
}
