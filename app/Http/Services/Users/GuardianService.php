<?php

namespace App\Http\Services\Users;

use App\Models\Users\Guardian;

class GuardianService
{

    public function create($data, $user)
    {
        Guardian::create([
            'user_id' => $user->id
        ]);

    }
}
