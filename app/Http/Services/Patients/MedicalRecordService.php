<?php


namespace App\Http\Services\Patients;

use App\Models\Patient\MedicalRecord;
use App\Models\Users\User;
use App\Services\FilterService;
use App\Services\MessageService;

class MedicalRecordService
{

    public function index($data)
    {
        $query = MedicalRecord::query();

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
        $medicalRecord = MedicalRecord::find($id);

        if ($medicalRecord) {
            MessageService::abort(404, "السجل غير موجود");
        }

        return $medicalRecord;
    }

    public function create($data)
    {
        $user = User::auth();

        $data['added_by'] = $user->id;

        $medicalRecord  = MedicalRecord::create($data);

        return $medicalRecord;
    }

    public function udpate(MedicalRecord $medicalRecord, $data)
    {
        $medicalRecord->update($data);

        return $medicalRecord;
    }

    public function delete(MedicalRecord $medicalRecord)
    {
        $medicalRecord->delete();
    }
}
