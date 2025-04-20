<?php

namespace App\Http\Controllers\Users;

use App\Http\Controllers\Controller;
use App\Http\Requests\Users\Auth\ForgetPasswordRequest;
use App\Http\Requests\Users\Auth\LoginRequest;
use App\Http\Requests\Users\Auth\RegisterRequest;
use App\Http\Requests\Users\Auth\RestPasswordRequest;
use App\Http\Requests\Users\Auth\VerifyCodeRequest;
use App\Http\Resources\Users\UserResource;
use App\Http\Services\Users\AuthService;
use App\Models\Users\User;
use App\Services\FirebaseService;
use Illuminate\Support\Facades\Log;
use Laravel\Sanctum\PersonalAccessToken;
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

        // log user ingo
        Log::info($user->role);
        Log::info($request->device_token);
        if ($user->isAdmin() && $request->device_token != null) {
            FirebaseService::subscribeToAllTopic($request, $user);
        }

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

    public function register(RegisterRequest $request)
    {
        $user =  $this->authService->register($request->validated());

        // Mail::to($user->email)->send(new VerifyEmail($verifyCode));

        return response()->json([
            'success' => true,
            'message' => 'تم إنشاء الحساب بنجاح. يرجى التحقق من بريدك الإلكتروني.',
        ]);
    }

    public function verifyCode(VerifyCodeRequest $request)
    {
        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return response()->json([
                'success' => false,
                'status' => 404,
                'message' => 'المستخدم غير موجود',
            ], 404);
        }

        ## TODO: Un Comment This 
        // if (! $this->authService->verifyCode($user, $request->verify_code)) {
        //     return response()->json([
        //         'success' => false,
        //         'status' => 401,
        //         'message' => 'Invalid or expired verification code',
        //     ], 401);
        // }

        if ($user->approve == 0)
            $user->update([
                'verified' => 1
            ]);

        $token = $user->createToken($user->first_name . '-AuthToken')->plainTextToken;

        return response()->json([
            'success' => true,
            'message' => 'تم التحقق بنجاح.',
            'access_token' => $token,
            'user' => $user,
        ]);
    }

    public function forgetPassword(ForgetPasswordRequest $request)
    {

        $res =  $this->authService->forgetPassword($request->validated());

        $data = $request->validated();

        $role = $data['role'];

        $roleName = $role == 'guardian' ? "أولياء الأمور" : "الأطباء";



        if (!$res) {
            return response()->json([
                'success' => false,
                'message' => "هذا البريد الإلكتروني غير موجود في $roleName .",
            ], 404);
        }

        return response()->json([
            'success' => true,
            'message' => 'تم إرسال رمز التحقق إلى البريد الإلكتروني، يرجى التحقق منه.',
        ]);
    }

    public function resetPassword(RestPasswordRequest $request)
    {
        $res =  $this->authService->resetPassword($request->validated());

        if ($res['success'] == true) {
            return response()->json(
                [
                    'success' => true,
                    'access_token' => $res['token'],
                    'message' => 'تم تحديث كلمة المرور بنجاح'
                ],
                201,
            );
        }
    }


    public function logout()
    {
        $token = request()->bearerToken();

        $this->authService->logout(PersonalAccessToken::findToken($token));

        return response()->json([
            'success' => true,
            'message' => 'تم تسجيل الخروج بنجاح',
        ], 200);
    }

    public function requestDeleteAccount()
    {

        $user = User::auth();
        $this->authService->requestDeleteAccount($user);

        return response()->json([
            'success' => true,
            'message' => 'لقد أرسلنا رمزًا إلى بريدك الإلكتروني لتأكيد حذف حسابك.',
        ]);
    }

    public function confirmDeleteAccount(Request $request)
    {
        $request->validate([
            'verify_code' => 'required|string',
        ]);

        $user = User::auth();
        $res = $this->authService->confirmDeleteAccount($user, $request->verify_code);

        if (!$res) {
            return response()->json([
                'success' => false,
                'message' => 'رمز التحقق غير صالح.',
            ], 400);
        }

        return response()->json([
            'success' => true,
            'message' => 'تم حذف حسابك بنجاح.',
        ]);
    }
}
