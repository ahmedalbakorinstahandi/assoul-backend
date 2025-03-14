<?php

namespace App\Http\Controllers\Users;

use App\Http\Controllers\Controller;
use App\Http\Requests\Users\Auth\LoginRequest;
use App\Http\Resources\Users\UserResource;
use App\Http\Services\Users\AuthService;
use Illuminate\Http\Request;
use Laravel\Sanctum\PersonalAccessToken;

class AuthController extends Controller
{
    protected $authService;

    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }


    public function login(LoginRequest $request)
    {
        $user = $this->authService->login($request->validated());

        return response()->json(
            [
                'success' => true,
                'user_token' => $user->token,
                'data' => new UserResource($user),
                'message' => 'تم تسجيل الدخول بنجاح',
            ],
            200
        );
    }

    public function logout()
    {
        $token = request()->bearerToken();

        $this->authService->logout(PersonalAccessToken::findToken($token));

        return response()->json([
            'success' => true,
            'message' => 'User logged out successfully',
        ], 200);
    }
}
