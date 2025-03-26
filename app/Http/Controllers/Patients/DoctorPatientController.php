<?php

namespace App\Http\Controllers\Patients;

use App\Http\Controllers\Controller;
use App\Http\Requests\Patients\DoctorPatient\FollowRequest;
use App\Http\Resources\Patients\DoctorPatientResource;
use App\Http\Services\Patients\DoctorPatientService;
use Illuminate\Http\Request;

class DoctorPatientController extends Controller
{
    protected $doctorPatientService;

    public function __construct(DoctorPatientService $doctorPatientService)
    {
        $this->doctorPatientService = $doctorPatientService;
    }

    public function follow(FollowRequest $request)
    {
        $data = $request->validated();

        $doctorPatient = $this->doctorPatientService->follow($data);

        return response()->json(
            [
                'success' => true,
                'data' => $doctorPatient != null ? new DoctorPatientResource($doctorPatient) : null,
                'message' => 'تمت العملية بنجاح'
            ],
            201
        );
    }
}
