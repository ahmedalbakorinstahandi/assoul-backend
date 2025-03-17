<?php

use App\Http\Controllers\Schedules\AppointmentController;
use App\Http\Controllers\Users\DoctorController;
use App\Http\Middleware\DoctorMiddleware;
use Illuminate\Support\Facades\Route;

Route::prefix('doctors')->middleware(['auth:sanctum', DoctorMiddleware::class])->group(function () {

    Route::get('profile/', [DoctorController::class, 'getDoctorData']);
    Route::post('profile/', [DoctorController::class, 'updateProfile']);

    Route::prefix('schedules')->group(function () {
        Route::get('/appointments', [AppointmentController::class, 'index']);
        Route::get('/appointments/{id}', [AppointmentController::class, 'show']);
        Route::post('/appointments', [AppointmentController::class, 'create']);
        Route::put('/appointments/{id}', [AppointmentController::class, 'update']);
        Route::delete('/appointments/{id}', [AppointmentController::class, 'delete']);
    });
});
