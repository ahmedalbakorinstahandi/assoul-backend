<?php

namespace App\Http\Permissions\Health;

use App\Models\Health\BloodSugarReading;
use App\Models\Users\User;
use App\Services\MessageService;

class BloodSugarReadingPermission
{
    public static function index($query)
    {
        $user = User::auth();

        if ($user->isPatient()) {
            $query->where('patient_id', $user->patient->id);
        }

        if ($user->isGuardian() && optional($user->guardian)->children) {
            $childrenIds = $user->guardian->children->pluck('id')->toArray();
            $query->orWhereIn('patient_id', $childrenIds);
        }



        return $query;
    }

    public static function show(BloodSugarReading $bloodSugarReading)
    {
        $user = User::auth();

        if ($user->isPatient() && $bloodSugarReading->patient_id !== $user->patient->id) {
            MessageService::abort(403, 'غير مسموح لك بالوصول لهذه البيانات');
        }

        if ($user->isGuardian() && optional($user->guardian)->children) {
            $isChild = $user->guardian->children->contains('id', $bloodSugarReading->patient_id);
            if (!$isChild) {
                MessageService::abort(403, 'غير مسموح لك بالوصول لهذه البيانات');
            }
        }
    }

    public static function create($data)
    {
        $user = User::auth();

        if ($user->isPatient()) {
            $data['patient_id'] = $user->patient->id;
        }

        if ($user->isGuardian() && optional($user->guardian)->children) {
            $childrenIds = $user->guardian->children->pluck('id')->toArray();
            if (!in_array($data['patient_id'], $childrenIds)) {
                MessageService::abort(403, 'غير مسموح لك بإضافة البيانات لهذا الطفل');
            }
        }


        return $data;
    }

    public static function update(BloodSugarReading $bloodSugarReading)
    {
        $user = User::auth();

        if ($user->isPatient() && $bloodSugarReading->patient_id !== $user->patient->id) {
            MessageService::abort(403, 'غير مسموح لك بتعديل هذه البيانات');
        }

        if ($user->isGuardian() && optional($user->guardian)->children) {
            $isChild = $user->guardian->children->contains('id', $bloodSugarReading->patient_id);
            if (!$isChild) {
                MessageService::abort(403, 'غير مسموح لك بتعديل هذه البيانات');
            }
        }
    }

    public static function delete(BloodSugarReading $bloodSugarReading)
    {
        $user = User::auth();

        if ($user->isPatient() && $bloodSugarReading->patient_id !== $user->patient->id) {
            MessageService::abort(403, 'غير مسموح لك بحذف هذه البيانات');
        }

        if ($user->isGuardian() && optional($user->guardian)->children) {
            $isChild = $user->guardian->children->contains('id', $bloodSugarReading->patient_id);
            if (!$isChild) {
                MessageService::abort(403, 'غير مسموح لك بحذف هذه البيانات');
            }
        }

        return $bloodSugarReading;
    }
}
