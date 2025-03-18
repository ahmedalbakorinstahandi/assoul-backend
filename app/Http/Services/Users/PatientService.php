<?php

namespace App\Http\Services\Users;

use App\Http\Permissions\Users\PatientPermission;
use App\Models\Users\ChildrenGuardian;
use App\Models\Users\Guardian;
use App\Models\Users\Patient;
use App\Models\Users\User;
use App\Services\FilterService;
use App\Services\ImageService;
use App\Services\MessageService;

class PatientService
{

    public function getPatientData()
    {
        $user = User::auth();


        $patient = $user->patient;

        $patient->load(['user', 'guardian', 'medicalRecords', 'instructions', 'notes']);

        return $patient;
    }

    public function updateAvatar($data)
    {
        $user = User::auth();

        $imageName = ImageService::storeImage($data['avatar'], 'avatars');

        $user->avatar = $imageName;
        $user->save();

        $patient = $user->patient;

        $patient->load(['user', 'guardian', 'medicalRecords', 'instructions', 'notes']);

        return $patient;
    }


    public function index($data)
    {
        $query = Patient::query()->with(['user', 'guardian.user', 'medicalRecords', 'instructions', 'notes']);

        $searchFields = [
            ['user.first_name', 'user.last_name'],
            'user.phone',
        ];
        $numericFields = ['height', 'weight', 'diabetes_diagnosis_age'];
        $exactMatchFields = ['gender', 'guardian.guardian_id', 'id', 'user_id'];
        $dateFields = ['birth_date', 'created_at'];
        $inFields = ['gender'];


        $query = PatientPermission::index($query);


        return FilterService::applyFilters(
            $query,
            $data,
            $searchFields,
            $numericFields,
            $dateFields,
            $exactMatchFields,
            $inFields
        );
    }

    public function show($id)
    {

        $patient = Patient::with(['user', 'guardian.user', 'medicalRecords', 'instructions', 'notes'])->find($id);

        if (!$patient) {
            MessageService::abort(404, 'المريض غير موجود');
        }

        PatientPermission::show($patient);

        return $patient;
    }


    public function create($data)
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

        $patient->load(['user', 'guardian.user', 'medicalRecords', 'instructions', 'notes']);

        return $patient;
    }

    public function update($patient, $data)
    {

        PatientPermission::update($patient, $data);

        if (isset($data['user']['avatar'])) {
            $imageName = ImageService::storeImage($data['user']['avatar'], 'avatars');
            $patient->user->avatar = $imageName;
        }

        if (isset($data['user'])) {
            $patient->user->update($data['user']);
        }

        unset($data['user']);

        $patient->update($data);

        $patient->load(['user', 'guardian.user', 'medicalRecords', 'instructions', 'notes']);

        return $patient;
    }

    public function delete($patient)
    {
        PatientPermission::delete($patient);

        $patient->user->delete();
        ChildrenGuardian::where('patient_id', $patient->id)->delete();
        $patient->delete();
    }


    public function generateCode($patient)
    {

        $user = User::auth();

        if ($user->isGuardian() && optional($user->guardian)->children) {
            $childrenIds = $user->guardian->children->pluck('id')->toArray();
            if (!in_array($patient->id, $childrenIds)) {
                MessageService::abort(403, 'لا يمكنك توليد كود لهذا الطفل');
            }
        }

        $otp = rand(10000, 99999);

        $patient->user->otp = $otp;
        $patient->user->otp_expide_at = now()->addMinutes(5);
        $patient->user->save();

        $patient->load(['user', 'guardian.user', 'medicalRecords', 'instructions', 'notes']);

        return $patient;
    }
}
