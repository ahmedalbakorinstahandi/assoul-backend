<?php

namespace App\Http\Services\Health;

use App\Http\Permissions\Health\PhysicalActivityPermission;
use App\Models\Health\PhysicalActivity;
use App\Models\Users\ChildrenGuardian;
use App\Models\Users\Patient;
use App\Models\Users\User;
use App\Services\FilterService;
use App\Services\FirebaseService;
use App\Services\MessageService;

class PhysicalActivityService
{
    public function index($data)
    {
        $query = PhysicalActivity::query()->with(['patient.user']);

        $searchFields = ['description', 'notes'];
        $numericFields = ['duration'];
        $dateFields = ['activity_date'];
        $exactMatchFields = ['patient_id', 'intensity', 'activity_time'];

        $query = PhysicalActivityPermission::index($query);

        return FilterService::applyFilters($query, $data, $searchFields, $numericFields, $dateFields, $exactMatchFields);
    }

    public function show($id)
    {
        $activity = PhysicalActivity::find($id);

        if (!$activity) {
            MessageService::abort(404, 'هذا السجل غير موجود');
        }

        PhysicalActivityPermission::show($activity);

        return $activity;
    }

    public function create($data)
    {
        $data = PhysicalActivityPermission::create($data);

        $physicalActivity = PhysicalActivity::create($data);

        $user = User::auth();
        if ($user->isPatient()) {
            $this->sendNotificationOnPhysicalActivityCreation($physicalActivity, $data['patient_id']);
        }

        return $physicalActivity;
    }

    public function sendNotificationOnPhysicalActivityCreation(PhysicalActivity $physicalActivity, $patient_id)
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
                'id' => $physicalActivity->id,
                'type' => PhysicalActivity::class,
            ],
            'طفلك قام بنشاط بدني جديد',
            'تم تسجيل نشاط بدني بقيمة ' . $physicalActivity->duration . ' دقيقة من طفلك ' . $patient->user->first_name,
            'info',
        );
    }

    public function update($activity, $data)
    {
        PhysicalActivityPermission::update($activity);

        $activity->update($data);
        return $activity;
    }

    public function delete($activity)
    {
        PhysicalActivityPermission::delete($activity);

        $user = User::auth();
        if ($user->isPatient()) {
            $this->sendNotificationOnPhysicalActivityDeletion($activity, $activity->patient_id);
        }

        return $activity->delete();
    }

    public function sendNotificationOnPhysicalActivityDeletion(PhysicalActivity $activity, $patient_id)
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
                'id' => $activity->id,
                'type' => PhysicalActivity::class,
            ],
            'طفلك قام بحذف نشاط بدني',
            'تم حذف نشاط بدني بقيمة ' . $activity->duration . ' دقيقة من طفلك ' . $patient->user->first_name,
            'warning',
        );
    }
}
