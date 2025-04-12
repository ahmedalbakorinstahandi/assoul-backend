<?php

namespace App\Http\Services\Health;

use App\Http\Permissions\Health\BloodSugarReadingPermission;
use App\Models\Health\BloodSugarReading;
use App\Models\Users\ChildrenGuardian;
use App\Models\Users\Patient;
use App\Models\Users\User;
use App\Services\FilterService;
use App\Services\FirebaseService;
use App\Services\MessageService;

class BloodSugarReadingService
{
    public function index($data)
    {
        $qusery = BloodSugarReading::query()->with(['patient.user']);

        $searchFields = ['measurement_type', 'unit', 'notes'];
        $numericFields = ['value'];
        $dateFields = ['measured_at'];
        $exactMatchFields = ['patient_id', 'measurement_type', 'unit'];
        $inFields = ['measurement_type'];

        $qusery = BloodSugarReadingPermission::index($qusery);

        $qusery = FilterService::applyFilters(
            $qusery,
            $data,
            $searchFields,
            $numericFields,
            $dateFields,
            $exactMatchFields,
            $inFields
        );

        return $qusery;
    }

    public function show($id)
    {
        $bloodSugarReading = BloodSugarReading::find($id);

        if (!$bloodSugarReading) {
            MessageService::abort(404, 'قراءة سكر الدم غير موجودة');
        }

        BloodSugarReadingPermission::show($bloodSugarReading);

        return $bloodSugarReading;
    }


    public function create($data)
    {

        $data = BloodSugarReadingPermission::create($data);

        $bloodSugarReading = BloodSugarReading::create($data);

        $user = User::auth();
        if ($user->isPatient()) {
            $this->sendNotificationOnBloodSugarReadingCreation($bloodSugarReading, $data['patient_id']);
        }

        return $bloodSugarReading;
    }

    public function sendNotificationOnBloodSugarReadingCreation(BloodSugarReading $bloodSugarReading, $patient_id)
    {
        $patient = Patient::find($patient_id);

        $guardian = ChildrenGuardian::where('patient_id', $patient->id)->first()->guardian;

        // guardian:notification
        FirebaseService::sendToTopicAndStorage(
            'user-' . $guardian->user_id,
            [
                $guardian->user_id,
            ],
            [
                'id' => $bloodSugarReading->id,
                'type' => BloodSugarReading::class,
            ],
            'طفلك أضاف قراءة سكر جديدة',
            'تم تسجيل قراءة سكر جديدة بقيمة ' . $bloodSugarReading->value . ' من طفلك ' . $patient->user->first_name,
            'info',
        );
    }


    public function update(BloodSugarReading $bloodSugarReading, $data)
    {
        BloodSugarReadingPermission::update($bloodSugarReading);

        $bloodSugarReading->update($data);

        return $bloodSugarReading;
    }

    public function delete(BloodSugarReading $bloodSugarReading)
    {
        BloodSugarReadingPermission::delete($bloodSugarReading);

        $user = User::auth();
        if ($user->isPatient()) {
            $this->sendNotificationOnBloodSugarReadingDeletion($bloodSugarReading, $bloodSugarReading->patient_id);
        }

        return $bloodSugarReading->delete();
    }

    public function sendNotificationOnBloodSugarReadingDeletion(BloodSugarReading $bloodSugarReading, $patient_id)
    {
        $patient = Patient::find($patient_id);

        $guardian = ChildrenGuardian::where('patient_id', $patient->id)->first()->guardian;

        // guardian:notification
        FirebaseService::sendToTopicAndStorage(
            'user-' . $guardian->user_id,
            [
                $guardian->user_id,
            ],
            [
                'id' => $bloodSugarReading->id,
                'type' => BloodSugarReading::class,
            ],
            'طفلك قام بحذف قراءة سكر',
            'تم حذف قراءة سكر قيمته ' . $bloodSugarReading->value . ' من طفلك ' . $patient->user->first_name,
            'warning',
        );
    }
}
