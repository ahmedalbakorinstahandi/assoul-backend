<?php

namespace App\Http\Controllers\Users;

use App\Models\Users\User;
use App\Services\ImageService;

class UserService
{
    public function create($data)
    {
        if ($data['avatar']) {
            $imageName = ImageService::storeImage($data['avatar'], 'avatars');
            $data['avatar'] = $imageName;
        }

        if ($data['password']) {
            $data['password'] = bcrypt($data['password']);
        }



        $user = User::create($data);

        return $user;
    }

    public function update($user, $data)
    {
        if ($data['avatar']) {
            $imageName = ImageService::storeImage($data['avatar'], 'avatars');
            $data['avatar'] = $imageName;
        }

        if ($data['password']) {
            $data['password'] = bcrypt($data['password']);
        }

        $user->update($data);

        return $user;
    }
}
