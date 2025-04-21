<?php

namespace App\Http\Services\Users;

use App\Http\Controllers\Users\UserService;
use App\Models\Users\ChildrenGuardian;
use App\Models\Users\Guardian;
use App\Models\Users\User;
use App\Services\FilterService;
use App\Services\ImageService;
use App\Services\MessageService;

class GuardianService
{

    public function getGuardianData()
    {
        $user = User::auth();

        $guardian = $user->guardian;

        $guardian->load(['user']);

        return $guardian;
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
        }

        $guardian = $user->guardian;

        $guardian->load(['user']);

        return $guardian;
    }

    public function index($data)
    {
        $query = Guardian::query()->with(['user']);

        $searchFields = [
            ['user.first_name', 'user.last_name'],
            'user.phone',
            'user.email'
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

        $guardian = Guardian::find($id);

        if (!$guardian) {
            MessageService::abort(404, 'الوصي غير موجود');
        }

        $guardian->load(['user']);

        return $guardian;
    }

    public function create($data, $user = null)
    {

        if (!$user && isset($data['user'])) {
            $userService = new UserService();
            // role
            $data['user']['role'] = 'guardian';
            $user = $userService->create($data['user']);
        }

        $guardian =  Guardian::create([
            'user_id' => $user->id
        ]);

        $guardian->load(['user']);

        return $guardian;
    }

    public function update($guardian, $data)
    {
        $userService = new UserService();

        if (isset($data['user'])) {

            $userService->update($guardian->user, $data['user']);
        }

        $guardian->load(['user']);

        return $guardian;
    }

    public function delete($guardian)
    {
        $guardian->user->delete();
        ChildrenGuardian::where('guardian_id', $guardian->id)->delete();
        $guardian->delete();
    }
}
