<?php

namespace App\Http\Permissions\Users;

use App\Models\Users\Guardian;
use App\Models\Users\User;

class PatientPermission
{
    public static function index($query)
    {
        $user = User::auth();

        if ($user->isPatient()) {
            $query->where('id', $user->patient->id);
        }

        if ($user->isGuardian() && optional($user->guardian)->children) {
            $childrenIds = $user->guardian->children->pluck('id')->toArray();
            $query->orWhereIn('id', $childrenIds);
        }

        return $query;
    }

    public static function show($patient)
    {
        $user = User::auth();

        if ($user->isPatient() && $user->patient->id !== $patient->id) {
            abort(403, 'لا يمكنك عرض هذا المريض');
        }

        if ($user->isGuardian() && optional($user->guardian)->children) {
            $childrenIds = $user->guardian->children->pluck('id')->toArray();
            if (!in_array($patient->id, $childrenIds)) {
                abort(403, 'لا يمكنك عرض هذا المريض');
            }
        }
    }

    public static function update($patient, $data)
    {
        $user = User::auth();

        if ($user->isGuardian() && optional($user->guardian)->children) {
            $childrenIds = $user->guardian->children->pluck('id')->toArray();
            if (!in_array($patient->id, $childrenIds)) {
                abort(403, 'لا يمكنك تعديل هذا المريض');
            }
        }
    }

    public static function delete($patient)
    {
        $user = User::auth();

        if ($user->isGuardian() && optional($user->guardian)->children) {
            $childrenIds = $user->guardian->children->pluck('id')->toArray();
            if (!in_array($patient->id, $childrenIds)) {
                abort(403, 'لا يمكنك حذف هذا المريض');
            }
        }
    }
}
