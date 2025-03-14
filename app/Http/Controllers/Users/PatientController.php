<?php

namespace App\Http\Controllers\Users;

use App\Http\Controllers\Controller;
use App\Http\Requests\Users\Patient\UpdateAvatarRequest;
use App\Http\Resources\Users\PatientResource;
use App\Http\Services\Users\PatientService;
use Illuminate\Http\Request;

class PatientController extends Controller
{
    protected $patientService;

    public function __construct(PatientService $patientService)
    {
        $this->patientService = $patientService;
    }

    public function getPatientData()
    {
        $patient = $this->patientService->getPatientData();

        return response()->json(
            [
                'success' => true,
                'data' => new PatientResource($patient),
            ],
            200
        );
    }

    public function updateAvatar(UpdateAvatarRequest $request)
    {
        $patient = $this->patientService->updateAvatar($request->validated());

        return response()->json(
            [
                'success' => true,
                'data' => new PatientResource($patient),
                'message' => 'تم تحديث الصورة بنجاح',
            ],
            200
        );
    }
}
