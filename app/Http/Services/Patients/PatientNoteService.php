<?php

namespace App\Http\Services\Patients;

use App\Models\Patient\PatientNote;
use App\Models\Users\User;
use App\Services\FilterService;
use App\Services\MessageService;

class PatientNoteService
{

    public function index($data)
    {
        $query = PatientNote::query();

        $searchFields = ['content'];
        $numericFields = [];
        $exactMatchFields = ['added_by', 'patient_id'];
        $dateFields = [];
        $inFields = [];


        return FilterService::applyFilters(
            $query,
            $data,
            $searchFields,
            $numericFields,
            $dateFields,
            $exactMatchFields,
            $inFields,
        );
    }

    public function show($id)
    {
        $patientNote = PatientNote::find($id);

        if (!$patientNote) {
            MessageService::abort(404, "السجل غير موجود");
        }

        return $patientNote;
    }

    public function create($data)
    {
        $user = User::auth();

        $data['added_by'] = $user->id;

        $patientNote  = PatientNote::create($data);

        return $patientNote;
    }

    public function udpate(PatientNote $patientNote, $data)
    {
        $patientNote->update($data);

        return $patientNote;
    }

    public function delete(PatientNote $patientNote)
    {
        $patientNote->delete();
    }
}
