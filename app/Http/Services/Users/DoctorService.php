<?php



namespace App\Http\Services\Users;

use App\Models\Users\Doctor;

class DoctorService
{

    public function create($data, $user)
    {
        $data['user_id'] = $user->id;

        Doctor::create($data);
    }
}
