<?php

namespace App\Http\Controllers\Users;

use App\Models\Users\User;
use App\Services\ImageService;

class UserService
{
    public function create($data)
    {
        if (isset($data['avatar']) && $data['avatar'] instanceof \Illuminate\Http\UploadedFile) {
            $imageName = ImageService::storeImage($data['avatar'], 'avatars');
            $data['avatar'] = $imageName;
        }

        if (isset($data['password'])) {
            $data['password'] = bcrypt($data['password']);
        }



        $user = User::create($data);

        return $user;
    }

    public function update($user, $data)
    {
        if (isset($data['avatar']) && $data['avatar'] instanceof \Illuminate\Http\UploadedFile) {
            $imageName = ImageService::storeImage($data['avatar'], 'avatars');
            $data['avatar'] = $imageName;
        }

        if (isset($data['password'])) {
            $data['password'] = bcrypt($data['password']);
        }

        $userData = array_filter($data, function ($value) {
            return !is_null($value);
        });
        $user->update($userData);

        return $user;
    }
}
