<?php

namespace App\Http\Permissions\Health;

use App\Models\Health\Meal;
use App\Models\Users\User;
use App\Services\MessageService;

class MealPermission
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

    public static function show(Meal $meal)
    {
        $user = User::auth();

        if ($user->isPatient() && $meal->patient_id !== $user->patient->id) {
            MessageService::abort(403, 'غير مسموح لك بالوصول لهذه البيانات');
        }

        if ($user->isGuardian() && optional($user->guardian)->children) {
            $childrenIds = $user->guardian->children->pluck('id')->toArray();
            if (!in_array($meal->patient_id, $childrenIds)) {
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
                MessageService::abort(403, 'غير مسموح لك بإضافة بيانات لهذه الوجبة.');
            }
        }


        return $data;
    }

    public static function update(Meal $meal)
    {
        $user = User::auth();

        if ($user->isPatient() && $meal->patient_id !== $user->patient->id) {
            MessageService::abort(403, 'غير مسموح لك بتحديث هذه البيانات');
        }

        if ($user->isGuardian() && optional($user->guardian)->children) {
            $childrenIds = $user->guardian->children->pluck('id')->toArray();
            if (!in_array($meal->patient_id, $childrenIds)) {
                MessageService::abort(403, 'غير مسموح لك بتحديث هذه البيانات');
            }
        }
    }

    public static function delete(Meal $meal)
    {
        $user = User::auth();

        if ($user->isPatient() && $meal->patient_id !== $user->patient->id) {
            MessageService::abort(403, 'غير مسموح لك بحذف هذه البيانات');
        }

        if ($user->isGuardian() && optional($user->guardian)->children) {
            $childrenIds = $user->guardian->children->pluck('id')->toArray();
            if (!in_array($meal->patient_id, $childrenIds)) {
                MessageService::abort(403, 'غير مسموح لك بحذف هذه البيانات');
            }
        }
    }
}
