<?php

namespace App\Http\Services\Users;

use App\Models\Users\ChildrenGuardian;
use App\Models\Users\Patient;
use App\Models\Users\User;
use App\Services\FirebaseService;
use App\Services\MessageService;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;

class AuthService
{
    public function login($loginUserData)
    {

        if ($loginUserData['role'] == 'child') {
            $user = User::where('role', 'patient')
                ->where('otp', $loginUserData['code'])
                ->where('otp_expide_at', '>', now())
                // TODO:  verified is true
                ->first();

            if (!$user) {
                MessageService::abort(422, 'رمز غير صالح');
            }


            $patient = $user->patient;
            // $guardian = $patient->guardian;

            $guardian = ChildrenGuardian::where('patient_id', $patient->id)->first()->guardian;
            if ($guardian) {
                // guardian:notification
                FirebaseService::sendToTopicAndStorage(
                    'user-' . $guardian->user_id,
                    [
                        $guardian->user_id,
                    ],
                    [
                        'id' => $patient->id,
                        'type' => Patient::class,
                    ],
                    'طفلك قام بتسجيل الدخول',
                    'لقد قام طفلك ' . $patient->user->first_name . ' بتسجيل الدخول إلى حسابه.',
                    'info',
                );
            }
        } else {

            $user = User::where('email', $loginUserData['email'])
                ->where('role', $loginUserData['role'])
                // TODO:  verified is true

                ->first();

            if (!$user || !Hash::check($loginUserData['password'], $user->password)) {
                MessageService::abort(422, 'البريد الالكتروني او كلمة المرور غير صحيحة');
            }


           
        }

        $user->token = $user->createToken('authToken')->plainTextToken;

        return $user;
    }

    public function register($requestData)
    {
        $verifyCode = rand(100000, 999999);
        $codeExpiry = Carbon::now()->addMinutes(30);

        $user = User::create([
            'first_name' => $requestData['first_name'],
            'last_name' => $requestData['last_name'],
            'email' => $requestData['email'],
            'password' => Hash::make($requestData['password']),
            'phone' => $requestData['phone'],
            'otp' => $verifyCode,
            'otp_expide_at' => $codeExpiry,
            'verified' => 0,
            'role' => $requestData['role'],
            'status' => 'Active',
        ]);


        if ($requestData['role'] == 'guardian') {
            $guardianService = new GuardianService();

            $guardianService->create([], $user);
        }


        if ($requestData['role'] == 'doctor') {
            $doctorService = new DoctorService();

            $doctorService->create($requestData['doctor'], $user);
        }

        return $user;
    }

    public function verifyCode($user, $verifyCode)
    {
        if ($user->verify_code !== $verifyCode || Carbon::now()->greaterThan($user->code_expiry_date)) {
            return false;
        }

        $user->update([
            'verified' => 1,
            'otp' => null,
            'otp_expide_at' => null,
        ]);

        return $user;
    }

    public function forgetPassword($requestData)
    {
        $email = $requestData['email'];

        $user = User::where('email', $email)->where('role', $requestData['role'])->first();


        if (!$user) {
            return false;
        }

        $verifyCode = rand(100000, 999999);
        $codeExpiry = Carbon::now()->addMinutes(30);

        $user->update([
            'otp' => $verifyCode,
            'otp_expide_at' => $codeExpiry,
        ]);

        # TODO
        // Mail::to($user->email)->send(new VerifyEmail($verifyCode));

        return true;
    }

    public function resetPassword($requestData)
    {
        $user = User::auth();

        $password = $requestData['password'];
        $user->update([
            'password' => Hash::make($password),
        ]);

        $user->tokens()->delete();

        $newToken = $user->createToken('NewTokenName')->plainTextToken;

        return [
            'success' => true,
            'token' => $newToken,
        ];
    }

    public function logout($token)
    {
        return $token->delete();
    }

    public function requestDeleteAccount(User $user)
    {
        $otp = rand(100000, 999999);
        $otpExpideAt = Carbon::now()->addMinutes(30);

        $user->update([
            'otp' => $otp,
            'otp_expide_at' => $otpExpideAt,
        ]);

        # TODO
        // Mail::to($user->email)->send(new VerifyEmail($verifyCode));   
    }

    public function confirmDeleteAccount(User $user, $code)
    {
        // TODO: Uncomment this
        // if ($user->otp !== $code || Carbon::now()->greaterThan($user->otp_expide_at)) {
        //     return false;
        // }

        if ($user->isPatient()) {
            ChildrenGuardian::where('patient_id', $user->patient->id)->delete();
            $user->patient->delete();
        }
        if ($user->isGuardian()) {
            ChildrenGuardian::where('guardian_id', $user->guardian->id)->delete();
            $user->guardian->delete();
        }

        if ($user->isDoctor()) {
            $user->doctor->delete();
        }

        $user->delete();

        return true;
    }
}
