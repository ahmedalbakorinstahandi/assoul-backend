<?php



namespace App\Http\Services\Users;

class DoctorService
{

    public function create($data, $user)
    {
        $user->doctor->create($data);
    }
}
