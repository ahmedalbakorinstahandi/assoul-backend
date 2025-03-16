<?php

namespace App\Http\Services\Users;

use App\Models\Users\ChildrenGuardian;
use App\Models\Users\Guardian;
use App\Models\Users\User;
use App\Services\ImageService;

class GuardianService
{




    public function create($data, $user)
    {
        Guardian::create([
            'user_id' => $user->id
        ]);
    }


    public function addCild($data)
    {
        $otp = rand(10000, 99999);

        $avatarName = ImageService::storeImage($data['avatar'], 'avatars');

        $userPatient = User::create(
            [
                'first_name' => $data['first_name'],
                'last_name' => $data['last_name'],
                'role' => 'patient',
                'password' => bcrypt('NONE_PASSWORD'),
                'otp' => $otp,
                'otp_expide_at' => now()->addMinutes(5),
                'verified' => true,
                'avatar' => $avatarName,
                'status' => 'Active',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        );

        $patient = $userPatient->patient()->create(
            [
                'gender' => $data['gender'],
                'birth_date' => $data['birth_date'],
                'height' => $data['height'],
                'weight' => $data['weight'],
                'insulin_doses' => 4,
                'points' => 0,
                'diabetes_diagnosis_age' => $data['diabetes_diagnosis_age'],
                'created_at' => now(),
                'updated_at' => now(),
            ]
        );

        $user = User::auth();

        if ($user->isGuardian()) {
            $guardian = $user->guardian;
        } else {
            $guardian = Guardian::find($data['guardian_id']);
        }

        ChildrenGuardian::create([
            'guardian_id' => $guardian->id,
            'patient_id' => $patient->id,
        ]);

        $patient->load('user');

        return $patient;

        //data has : first_name, last_name, avatar, gender, birth_date, height, weight, diabetes_diagnosis_age , guardian_id if user is admin
    }
}
