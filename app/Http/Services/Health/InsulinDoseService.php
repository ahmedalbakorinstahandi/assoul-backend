<?php

namespace App\Http\Services\Health;

use App\Http\Permissions\Health\InsulinDosePermission;
use App\Models\Health\InsulinDose;
use App\Models\Users\Patient;
use App\Models\Users\User;
use App\Services\FilterService;
use App\Services\FirebaseService;
use App\Services\MessageService;

class InsulinDoseService
{
    public function index($data)
    {
        $query = InsulinDose::query()->with(['patient.user']);

        $searchFields = ['insulin_type', 'injection_site'];
        $numericFields = ['dose_units'];
        $dateFields = ['taken_date'];
        $exactMatchFields = ['patient_id', 'taken_time'];

        $query = InsulinDosePermission::index($query);

        return FilterService::applyFilters(
            $query,
            $data,
            $searchFields,
            $numericFields,
            $dateFields,
            $exactMatchFields
        );
    }

    public function show($id)
    {
        $insulinDose = InsulinDose::find($id);

        if (!$insulinDose) {
            MessageService::abort(404, 'جرعة الأنسولين غير موجودة');
        }

        InsulinDosePermission::show($insulinDose);

        return $insulinDose;
    }

    public function create($data)
    {
        $data = InsulinDosePermission::create($data);

        $insulinDose = InsulinDose::create($data);

        $user = User::auth();
        if ($user->isPatient()) {
            $this->sendNotificationOnInsulinDoseCreation($insulinDose, $data['patient_id']);
        }

        return $insulinDose;
    }

    public function sendNotificationOnInsulinDoseCreation(InsulinDose $insulinDose, $patient_id)
    {
        $patient = Patient::find($patient_id);

        $guardian = $patient->guardian;

        // guardian:notification
        FirebaseService::sendToTopicAndStorage(
            'user' . $guardian->user_id,
            [
                $guardian->user_id,
            ],
            [
                'id' => $insulinDose->id,
                'type' => InsulinDose::class,
            ],
            'طفلك أخذ جرعة أنسولين جديدة',
            'تم تسجيل جرعة أنسولين مأخوذة بقيمة ' . $insulinDose->dose_units . ' من طفلك ' . $patient->user->first_name,
            'info',
        );
    }




    public function update($insulinDose, $data)
    {
        InsulinDosePermission::update($insulinDose);

        $insulinDose->update($data);

        return $insulinDose;
    }

    public function delete($insulinDose)
    {
        InsulinDosePermission::delete($insulinDose);

        $user = User::auth();
        if ($user->isPatient()) {
            $this->sendNotificationOnInsulinDoseDeletion($insulinDose, $insulinDose->patient_id);
        }

        return $insulinDose->delete();
    }

    public function sendNotificationOnInsulinDoseDeletion(InsulinDose $insulinDose, $patient_id)
    {
        $patient = Patient::find($patient_id);

        $guardian = $patient->guardian;

        // guardian:notification
        FirebaseService::sendToTopicAndStorage(
            'user' . $guardian->user_id,
            [
                $guardian->user_id,
            ],
            [
                'id' => $insulinDose->id,
                'type' => InsulinDose::class,
            ],
            'طفلك قام بحذف جرعة أنسولين',
            'تم حذف جرعة أنسولين بقيمة ' . $insulinDose->dose_units . ' من طفلك ' . $patient->user->first_name,
            'warning',
        );
    }
}
