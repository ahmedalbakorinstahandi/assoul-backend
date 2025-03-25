<?php


namespace App\Http\Services\Patients;

use App\Models\Patient\DoctorPatient;
use App\Models\Users\User;
use App\Services\FilterService;
use App\Services\MessageService;

class DoctorPatientService
{
    public function index($data)
    {
        $query = DoctorPatient::query();

        $searchFields = [];
        $numericFields = [];
        $exactMatchFields = ['doctor_id', 'patient_id'];
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

    public function follow($data)
    {
        $user = User::auth();


        if ($user->isDoctor()) {
            $data['doctor_id'] = $user->doctor->id;
        }


        $doctorPatient = DoctorPatient::where('doctor_id', $data['doctor_id'])
            ->where('patient_id', $data['patient_id'])
            ->first();


        if ($doctorPatient) {
            $doctorPatient->delete();
            return $doctorPatient;
        }

        $doctorPatient  = DoctorPatient::create($data);

        return $doctorPatient;
    }
}
