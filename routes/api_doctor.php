<?php

use App\Http\Controllers\Schedules\AppointmentController;
use App\Http\Controllers\Users\DoctorController;
use App\Http\Controllers\Users\PatientController;
use App\Http\Middleware\DoctorMiddleware;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Patients\InstructionController;
use App\Http\Controllers\Patients\MedicalRecordController;
use App\Http\Controllers\Patients\PatientNoteController;

Route::prefix('doctors')->middleware(['auth:sanctum', DoctorMiddleware::class])->group(function () {

    Route::get('profile/', [DoctorController::class, 'getDoctorData']);
    Route::post('profile/', [DoctorController::class, 'updateProfile']);

    Route::prefix('schedules')->group(function () {
        Route::get('/appointments', [AppointmentController::class, 'index']);
        Route::get('/appointments/{id}', [AppointmentController::class, 'show']);
        Route::post('/appointments', [AppointmentController::class, 'create']);
        Route::put('/appointments/{id}', [AppointmentController::class, 'update']);
        Route::delete('/appointments/{id}', [AppointmentController::class, 'delete']);
        Route::post('/appointments/{id}/cancel', [AppointmentController::class, 'cancel']);
    });


    Route::prefix('users')->group(function () {
        Route::get('/patients', [PatientController::class, 'index']);
        Route::get('/patients/{id}', [PatientController::class, 'show']);
    });


    Route::prefix('patients')->group(function () {
        Route::get('/medical-records', [MedicalRecordController::class, 'index']);
        Route::get('/medical-records/{id}', [MedicalRecordController::class, 'show']);
        Route::post('/medical-records', [MedicalRecordController::class, 'create']);
        Route::put('/medical-records/{id}', [MedicalRecordController::class, 'update']);
        Route::delete('/medical-records/{id}', [MedicalRecordController::class, 'delete']);


        Route::get('/notes', [PatientNoteController::class, 'index']);
        Route::get('/notes/{id}', [PatientNoteController::class, 'show']);
        Route::post('/notes', [PatientNoteController::class, 'create']);
        Route::put('/notes/{id}', [PatientNoteController::class, 'update']);
        Route::delete('/notes/{id}', [PatientNoteController::class, 'delete']);


        Route::get('/instructions', [InstructionController::class, 'index']);
        Route::get('/instructions/{id}', [InstructionController::class, 'show']);
        Route::post('/instructions', [InstructionController::class, 'create']);
        Route::put('/instructions/{id}', [InstructionController::class, 'update']);
        Route::delete('/instructions/{id}', [InstructionController::class, 'delete']);
    });
});
