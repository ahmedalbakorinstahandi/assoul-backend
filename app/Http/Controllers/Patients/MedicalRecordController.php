<?php

namespace App\Http\Controllers\Patients;

use App\Http\Controllers\Controller;
use App\Http\Requests\Patients\MedicalRecord\CreateRequest;
use App\Http\Requests\Patients\MedicalRecord\UpdateRequest;
use App\Http\Resources\Patients\MedicalRecordResource;
use App\Http\Services\Patients\MedicalRecordService;
use App\Services\ResponseService;
use Illuminate\Http\Request;

class MedicalRecordController extends Controller
{
    protected $medicalRecord;

    public function __construct(MedicalRecordService $medicalRecord)
    {
        $this->medicalRecord = $medicalRecord;
    }

    public function index()
    {

        $medicalRecords = $this->medicalRecord->index(request()->all());

        return response()->json(
            [
                'success' => true,
                'data' => MedicalRecordResource::collection($medicalRecords),
                'meta' => ResponseService::meta($medicalRecords),
            ],
            200
        );
    }

    public function show($id)
    {
        $medicalRecord = $this->medicalRecord->show($id);

        return response()->json(
            [
                'success' => true,
                'data' => new MedicalRecordResource($medicalRecord),
            ],
            200
        );
    }

    public function create(CreateRequest $request)
    {
        $medicalRecord = $this->medicalRecord->create($request->validated());

        return response()->json(
            [
                'success' => true,
                'data' => new MedicalRecordResource($medicalRecord),
                'message' => "تم إنشاء السجل بنجاح",
            ],
            200
        );
    }

    public function update(UpdateRequest $request, $id)
    {
        $medicalRecord = $this->medicalRecord->show($id);


        $medicalRecord = $this->medicalRecord->udpate($medicalRecord, $request->validated());

        return response()->json(
            [
                'success' => true,
                'data' => new MedicalRecordResource($medicalRecord),
                'message' => "تم تعديل السجل بنجاح",
            ],
            200
        );
    }

    public function delete($id)
    {
        $medicalRecord = $this->medicalRecord->show($id);


        $this->medicalRecord->delete($medicalRecord);

        return response()->json(
            [
                'success' => true,
                'message' => "تم حذف السجل بنجاح",
            ],
            200
        );
    }
}
