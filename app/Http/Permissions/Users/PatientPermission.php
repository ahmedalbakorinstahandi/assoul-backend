<?php

namespace App\Http\Permissions\Users;

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
            $query->orWhereIn('patient_id', $childrenIds);
        }
    }
}
