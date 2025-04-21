<?php



namespace App\Http\Services\Users;

use App\Http\Controllers\Users\UserService;
use App\Models\Users\Doctor;
use App\Models\Users\User;
use App\Services\FilterService;
use App\Services\ImageService;
use App\Services\MessageService;

class DoctorService
{


    public function getDoctorData()
    {
        $user = User::auth();

        $doctor = $user->doctor;

        $doctor->load(['user']);

        return $doctor;
    }


    public function updateProfile($data)
    {
        $user = User::auth();

        if (isset($data['user']['avatar'])) {
            $imageName = ImageService::storeImage($data['user']['avatar'], 'avatars');
            $data['user']['avatar'] = $imageName;
        }

        if (isset($data['user']['password'])) {
            $data['user']['password'] = bcrypt($data['user']['password']);
        }

        if (isset($data['user'])) {
            $userData = array_filter($data['user'], function ($value) {
                return !is_null($value);
            });
            $user->update($userData);
            unset($data['user']);
        }

        $doctor = $user->doctor;

        if (isset($data)) {
            $doctorData = array_filter($data, function ($value) {
                return !is_null($value);
            });
            $doctor->update($doctorData);
        }
        $doctor->load(['user']);

        return $doctor;
    }

    public function index($data)
    {
        $query = Doctor::query()->with(['user']);

        $searchFields = [
            ['user.first_name', 'user.last_name'],
            'user.phone',
            'user.email',
            'specialization',
            'classification_number',
            'workplace_clinic_location',
        ];
        $numericFields = [];
        $exactMatchFields = ['id', 'user_id'];
        $dateFields = ['created_at'];
        $inFields = ['user.status'];


        return FilterService::applyFilters(
            $query,
            $data,
            $searchFields,
            $numericFields,
            $exactMatchFields,
            $dateFields,
            $inFields
        );
    }

    public function show($id)
    {

        $doctor = Doctor::find($id);

        if (!$doctor) {
            MessageService::abort(404, 'الطبيب غير موجود');
        }

        $doctor->load(['user']);

        return $doctor;
    }


    public function create($data, $user = null)
    {
        if ($user == null) {
            $userService = new UserService();
            // role
            $data['user']['role'] = 'doctor';
            $user = $userService->create($data['user']);
            unset($data['user']);
        }

        $data['user_id'] = $user->id;

        $doctor = Doctor::create($data);

        $doctor->load('user');

        return $doctor;
    }

    public function update($doctor, $data)
    {
        $userService = new UserService();

        if (isset($data['user'])) {
            $userService->update($doctor->user, $data['user']);

            unset($data['user']);
        }

        $doctor->update($data);

        $doctor->load(['user']);

        return $doctor;
    }

    public function delete($doctor)
    {
        $doctor->user->delete();
        $doctor->delete();
    }
}
