<?php

namespace App\Http\Services\Users;

use App\Models\Users\User;
use App\Services\ImageService;

class PatientService
{

    public function getPatientData()
    {
        $user = User::auth();


        $patient = $user->patient;

        $patient->load(['user', 'guardian']);

        return $patient;
    }

    public function updateAvatar($data)
    {
        $user = User::auth();

        $imageName = ImageService::storeImage($data['avatar'], 'avatars');

        $user->avatar = $imageName;
        $user->save();

        $patient = $user->patient;

        return $patient;
    }
}
