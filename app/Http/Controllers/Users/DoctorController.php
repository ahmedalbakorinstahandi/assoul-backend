<?php

namespace App\Http\Controllers\Users;

use App\Http\Controllers\Controller;
use App\Http\Requests\Users\Doctor\CreateRequest;
use App\Http\Requests\Users\Doctor\UpdateProfileRequest;
use App\Http\Requests\Users\Doctor\UpdateRequest;
use App\Http\Resources\Users\DoctorResource;
use App\Http\Services\Users\DoctorService;
use App\Services\ResponseService;

class DoctorController extends Controller
{
    protected $doctorService;

    public function __construct(DoctorService $doctorService)
    {
        $this->doctorService = $doctorService;
    }

    public function getDoctorData()
    {
        $doctor = $this->doctorService->getDoctorData();

        return response()->json(
            [
                'success' => true,
                'data' => new DoctorResource($doctor),
            ],
            200
        );
    }

    public function updateProfile(UpdateProfileRequest $request)
    {
        $doctor = $this->doctorService->updateProfile($request->validated());

        return response()->json(
            [
                'success' => true,
                'data' => new DoctorResource($doctor),
                'message' => 'تم تحديث البيانات بنجاح',
            ],
            200
        );
    }

    public function index()
    {
        $doctors = $this->doctorService->index(request()->all());

        return response()->json(
            [
                'success' => true,
                'data' => DoctorResource::collection($doctors->items()),
                'meta' => ResponseService::meta($doctors),
            ],
            200
        );
    }

    public function show($id)
    {
        $doctor = $this->doctorService->show($id);

        return response()->json(
            [
                'success' => true,
                'data' => new DoctorResource($doctor),
            ],
            200
        );
    }

    // create
    public function create(CreateRequest $request)
    {

        $doctor = $this->doctorService->create($request->validated());

        return response()->json(
            [
                'success' => true,
                'data' => new DoctorResource($doctor),
                'message' => 'تم إضافة الطبيب بنجاح',
            ],
            200
        );
    }

    // update
    public function update(UpdateRequest $request, $id)
    {
        $doctor = $this->doctorService->show($id);

        $doctor = $this->doctorService->update($doctor, $request->validated());

        return response()->json(
            [
                'success' => true,
                'data' => new DoctorResource($doctor),
                'message' => 'تم تحديث البيانات بنجاح',
            ],
            200
        );
    }

    // delete
    public function delete($id)
    {
        $doctor = $this->doctorService->show($id);

        $this->doctorService->delete($doctor);

        return response()->json(
            [
                'success' => true,
                'message' => 'تم حذف البيانات بنجاح',
            ],
            200
        );
    }
}
