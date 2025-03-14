<?php

use App\Http\Controllers\Users\AuthController;
use Illuminate\Support\Facades\Route;


Route::prefix('auth')->group(function () {
    Route::post('login', [AuthController::class, 'login']);
    Route::middleware('auth:sanctum')->post('logout', [AuthController::class, 'logout']);
    Route::post('register', [AuthController::class, 'register']);
    Route::post('/verify-code', [AuthController::class, 'verifyCode']);
    Route::post('/forget-password', [AuthController::class, 'forgetpassword']);
    Route::post('/reset-password', [AuthController::class, 'resetpassword'])->middleware('auth:sanctum');
    Route::post('/request-delete-account', [AuthController::class, 'requestDeleteAccount'])->middleware('auth:sanctum');
    Route::post('/confirm-delete-account', [AuthController::class, 'confirmDeleteAccount'])->middleware('auth:sanctum');
});
