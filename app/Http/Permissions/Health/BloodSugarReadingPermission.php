<?php

namespace App\Http\Permissions\Health;

use App\Models\Health\BloodSugarReading;
use App\Models\Users\User;
use App\Services\MessageService;

class BloodSugarReadingPermission
{
    public static function index($qusery)
    {
        $user = User::auth();

        if ($user->isPatient()) {
            $qusery->where('patient_id', $user->id);
        }


        if ($user->isGuardian() && $user->guardian) {
            $user->guardian->children->each(function ($child) use ($qusery) {
                $qusery->orWhere('patient_id', $child->id);
            });
        }


        return $qusery;
    }

    public static function show(BloodSugarReading $bloodSugarReading)
    {
        $user = User::auth();

        if ($user->isPatient() && $bloodSugarReading->patient_id !== $user->id) {
            MessageService::abort(403, 'غير مسموح لك بالوصول لهذه البيانات');
        }

        if ($user->isGuardian() && $user->guardian) {
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
            $data['patient_id'] = $user->id;
        }

        if ($user->isGuardian() && $user->guardian) {
            $isChild = $user->guardian->children->contains('id', $data['patient_id']);
            if (!$isChild) {
                MessageService::abort(403, 'غير مسموح لك بإضافة البيانات لهذا الطفل');
            }
        }

        return $data;
    }

    public static function update(BloodSugarReading $bloodSugarReading)
    {
        $user = User::auth();

        if ($user->isPatient() && $bloodSugarReading->patient_id !== $user->id) {
            MessageService::abort(403, 'غير مسموح لك بتعديل هذه البيانات');
        }

        if ($user->isGuardian() && $user->guardian) {
            $isChild = $user->guardian->children->contains('id', $bloodSugarReading->patient_id);
            if (!$isChild) {
                MessageService::abort(403, 'غير مسموح لك بتعديل هذه البيانات');
            }
        }
    }

    public static function delete(BloodSugarReading $bloodSugarReading)
    {
        $user = User::auth();

        if ($user->isPatient() && $bloodSugarReading->patient_id !== $user->id) {
            MessageService::abort(403, 'غير مسموح لك بحذف هذه البيانات');
        }

        if ($user->isGuardian() && $user->guardian) {
            $isChild = $user->guardian->children->contains('id', $bloodSugarReading->patient_id);
            if (!$isChild) {
                MessageService::abort(403, 'غير مسموح لك بحذف هذه البيانات');
            }
        }

        return $bloodSugarReading;
    }
}
