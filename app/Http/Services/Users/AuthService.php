<?php

namespace App\Http\Services\Users;

use App\Models\Users\User;
use App\Services\MessageService;
use Illuminate\Support\Facades\Hash;

class AuthService
{
    public function login($loginUserData)
    {

        if ($loginUserData['role'] == 'child') {
            $user = User::where('role', 'patient')
                ->where('otp', $loginUserData['code'])
                ->where('otp_expide_at', '>', now())
                ->first();

            if (!$user) {
                MessageService::abort(422, 'رمز غير صالح');
            }
        } else {

            $user = User::where('email', $loginUserData['email'])
                ->where('role', $loginUserData['role'])
                ->first();

            if (!$user || !Hash::check($loginUserData['password'], $user->password)) {
                MessageService::abort(422, 'البريد الالكتروني او كلمة المرور غير صحيحة');
            }
        }

        $user->token = $user->createToken('authToken')->plainTextToken;

        return $user;
    }

    public function logout($token)
    {
        return $token->delete();
    }
}
