<?php

namespace App\Http\Controllers\Users;

use App\Http\Controllers\Controller;
use App\Http\Requests\Users\Guardian\CreateRequest;
use App\Http\Requests\Users\Guardian\UpdateProfileRequest;
use App\Http\Requests\Users\Guardian\UpdateRequest;
use App\Http\Resources\Users\GuardianResource;
use App\Http\Resources\Users\PatientResource;
use App\Http\Services\Users\GuardianService;
use App\Services\ResponseService;
use Illuminate\Http\Request;

class GuardianController extends Controller
{
    protected $guardianService;

    public function __construct(GuardianService $guardianService)
    {
        $this->guardianService = $guardianService;
    }

    public function getGuardianData()
    {
        $guardian = $this->guardianService->getGuardianData();

        return response()->json(
            [
                'success' => true,
                'data' => new GuardianResource($guardian),
            ],
            200
        );
    }

    public function updateProfile(UpdateProfileRequest $request)
    {
        $guardian = $this->guardianService->updateProfile($request->validated());

        return response()->json(
            [
                'success' => true,
                'data' => new GuardianResource($guardian),
                'message' => 'تم تحديث البيانات بنجاح',
            ],
            200
        );
    }


    public function index(Request $request)
    {
        $guardians = $this->guardianService->index($request->all());

        return response()->json(
            [
                'success' => true,
                'data' => GuardianResource::collection($guardians->items()),
                'meta' => ResponseService::meta($guardians),
            ],
            200
        );
    }


    public function show($id)
    {
        $guardian = $this->guardianService->show($id);

        return response()->json(
            [
                'success' => true,
                'data' => new GuardianResource($guardian),
            ],
            200
        );
    }


    // create
    public function create(CreateRequest $request)
    {

        $guardian = $this->guardianService->create($request->validated());

        return response()->json(
            [
                'success' => true,
                'data' => new GuardianResource($guardian),
                'message' => 'تم إضافة الوصي بنجاح',
            ],
            200
        );
    }

    // update
    public function update(UpdateRequest $request, $id)
    {
        $guardian = $this->guardianService->show($id);

        $guardian = $this->guardianService->update($guardian, $request->validated());

        return response()->json(
            [
                'success' => true,
                'data' => new GuardianResource($guardian),
                'message' => 'تم تحديث البيانات بنجاح',
            ],
            200
        );
    }

    // delete
    public function delete($id)
    {
        $guardian = $this->guardianService->show($id);

        $this->guardianService->delete($guardian);

        return response()->json(
            [
                'success' => true,
                'message' => 'تم حذف البيانات بنجاح',
            ],
            200
        );
    }
}
