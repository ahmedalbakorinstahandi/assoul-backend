<?php

namespace App\Http\Controllers\Users;

use App\Http\Controllers\Controller;
use App\Http\Requests\Users\Patient\AddChildRequest;
use App\Http\Requests\Users\Patient\UpdateAvatarRequest;
use App\Http\Requests\Users\Patient\UpdateRequest;
use App\Http\Resources\Games\GameResource;
use App\Http\Resources\General\EducationalContentResource;
use App\Http\Resources\Users\PatientResource;
use App\Http\Services\Users\PatientService;
use App\Models\Games\Game;
use App\Models\General\EducationalContent;
use App\Services\ResponseService;
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


    public function getHomeData()
    {
        $educationalContent = EducationalContent::inRandomOrder()->limit(1)->get()->first();
        $games = Game::orderBy('order')->limit(3)->get();

        return response()->json(
            [
                'success' => true,
                'data' => [
                    'educational_content' => new EducationalContentResource($educationalContent),
                    'games' => GameResource::collection($games),
                ],
            ],
            200
        );
    }


    public function index()
    {
        $patients = $this->patientService->index(request()->all());

        return response()->json(
            [
                'success' => true,
                'data' => PatientResource::collection($patients),
                'meta' => ResponseService::meta($patients),
            ],
            200
        );
    }

    public function show($id)
    {
        $patient = $this->patientService->show($id);

        return response()->json(
            [
                'success' => true,
                'data' => new PatientResource($patient),
            ],
            200
        );
    }

    public function create(AddChildRequest $request)
    {
        $patient =  $this->patientService->create($request->validated());

        return response()->json(

            [
                'success' => true,
                'message' => 'تم اضافة الطفل بنجاح',
                'data' =>  new PatientResource($patient),
            ]
        );
    }

    public function update($id, UpdateRequest $request)
    {
        $patient = $this->patientService->show($id);

        $patient = $this->patientService->update($patient, $request->validated());

        return response()->json(
            [
                'success' => true,
                'message' => 'تم تحديث البيانات بنجاح',
                'data' => new PatientResource($patient),
            ],
            200
        );
    }

    public function delete($id)
    {
        $patient = $this->patientService->show($id);

        $this->patientService->delete($patient);

        return response()->json(
            [
                'success' => true,
                'message' => 'تم حذف البيانات بنجاح',
            ],
            200
        );
    }
}
