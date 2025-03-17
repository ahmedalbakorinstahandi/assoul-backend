<?php

namespace App\Http\Controllers\Patients;

use App\Http\Controllers\Controller;
use App\Http\Requests\Patients\PatientNote\CreateRequest;
use App\Http\Requests\Patients\PatientNote\UpdateRequest;
use App\Http\Resources\Patients\PatientNoteResource;
use App\Http\Services\Patients\PatientNoteService;
use App\Services\ResponseService;
use Illuminate\Http\Request;

class PatientNoteController extends Controller
{
    protected $patientNote;

    public function __construct(PatientNoteService $patientNote)
    {
        $this->patientNote = $patientNote;
    }

    public function index()
    {

        $patientNotes = $this->patientNote->index(request()->all());

        return response()->json(
            [
                'success' => true,
                'data' => PatientNoteResource::collection($patientNotes),
                'meta' => ResponseService::meta($patientNotes),
            ],
            200
        );
    }

    public function show($id)
    {
        $patientNote = $this->patientNote->show($id);

        return response()->json(
            [
                'success' => true,
                'data' => new PatientNoteResource($patientNote),
            ],
            200
        );
    }

    public function create(CreateRequest $request)
    {
        $patientNote = $this->patientNote->create($request->validated());

        return response()->json(
            [
                'success' => true,
                'data' => new PatientNoteResource($patientNote),
                'message' => "تم إنشاء السجل بنجاح",
            ],
            200
        );
    }

    public function update(UpdateRequest $request, $id)
    {
        $patientNote = $this->patientNote->show($id);


        $patientNote = $this->patientNote->udpate($patientNote, $request->validated());

        return response()->json(
            [
                'success' => true,
                'data' => new PatientNoteResource($patientNote),
                'message' => "تم تعديل السجل بنجاح",
            ],
            200
        );
    }

    public function delete($id)
    {
        $patientNote = $this->patientNote->show($id);


        $this->patientNote->delete($patientNote);

        return response()->json(
            [
                'success' => true,
                'message' => "تم حذف السجل بنجاح",
            ],
            200
        );
    }
}
