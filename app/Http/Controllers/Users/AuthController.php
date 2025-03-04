<?php

namespace App\Http\Controllers\Users;

use App\Http\Controllers\Controller;
use App\Http\Requests\Users\Auth\LoginRequest;
use App\Http\Resources\Users\UserResource;
use App\Http\Services\Users\AuthService;
use Illuminate\Http\Request;

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
}
