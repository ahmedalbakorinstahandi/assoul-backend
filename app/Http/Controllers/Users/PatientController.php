<?php

namespace App\Http\Controllers\Users;

use App\Http\Controllers\Controller;
use App\Http\Requests\Users\Patient\UpdateAvatarRequest;
use App\Http\Resources\Games\GameResource;
use App\Http\Resources\General\EducationalContentResource;
use App\Http\Resources\Users\PatientResource;
use App\Http\Services\Users\PatientService;
use App\Models\Games\Game;
use App\Models\General\EducationalContent;
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
}
