<?php

use App\Http\Controllers\Health\BloodSugarReadingController;
use App\Http\Controllers\Health\InsulinDoseController;
use App\Http\Controllers\Health\MealController;
use App\Http\Controllers\Health\PhysicalActivityController;
use App\Http\Controllers\Schedules\AppointmentController;
use App\Http\Controllers\Tasks\SystemTaskController;
use App\Http\Controllers\Tasks\ToDoListController;
use App\Http\Controllers\Users\DoctorController;
use App\Http\Controllers\Users\GuardianController;
use App\Http\Controllers\Users\PatientController;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\GuardianMiddleware;
use App\Http\Controllers\Patients\InstructionController;
use App\Http\Controllers\Patients\MedicalRecordController;
use App\Http\Controllers\Patients\PatientNoteController;

Route::prefix('guardian')->middleware(['auth:sanctum', GuardianMiddleware::class])->group(function () {

    Route::get('profile/', [GuardianController::class, 'getGuardianData']);
    Route::post('profile/', [GuardianController::class, 'updateProfile']);


    Route::prefix('health')->group(function () {
        Route::get('/blood-sugar-readings', [BloodSugarReadingController::class, 'index']);
        Route::get('/blood-sugar-readings/{id}', [BloodSugarReadingController::class, 'show']);
        Route::post('/blood-sugar-readings', [BloodSugarReadingController::class, 'create']);
        Route::put('/blood-sugar-readings/{id}', [BloodSugarReadingController::class, 'update']);
        Route::delete('/blood-sugar-readings/{id}', [BloodSugarReadingController::class, 'delete']);


        Route::get('/insulin-doses', [InsulinDoseController::class, 'index']);
        Route::get('/insulin-doses/{id}', [InsulinDoseController::class, 'show']);
        Route::post('/insulin-doses', [InsulinDoseController::class, 'create']);
        Route::put('/insulin-doses/{id}', [InsulinDoseController::class, 'update']);
        Route::delete('/insulin-doses/{id}', [InsulinDoseController::class, 'delete']);


        Route::get('/physical-activities', [PhysicalActivityController::class, 'index']);
        Route::get('/physical-activities/{id}', [PhysicalActivityController::class, 'show']);
        Route::post('/physical-activities', [PhysicalActivityController::class, 'create']);
        Route::put('/physical-activities/{id}', [PhysicalActivityController::class, 'update']);
        Route::delete('/physical-activities/{id}', [PhysicalActivityController::class, 'delete']);


        Route::get('/meals', [MealController::class, 'index']);
        Route::get('/meals/{id}', [MealController::class, 'show']);
        Route::post('/meals', [MealController::class, 'create']);
        Route::put('/meals/{id}', [MealController::class, 'update']);
        Route::delete('/meals/{id}', [MealController::class, 'delete']);
    });


    Route::prefix('tasks')->group(function () {
        Route::get('/to-do-list', [ToDoListController::class, 'index']);
        Route::get('/to-do-list/{id}', [ToDoListController::class, 'show']);
        Route::post('/to-do-list', [ToDoListController::class, 'create']);
        Route::put('/to-do-list/{id}', [ToDoListController::class, 'update']);
        Route::delete('/to-do-list/{id}', [ToDoListController::class, 'delete']);
        Route::post('/to-do-list/{id}/check', [ToDoListController::class, 'check']);


        Route::get('/system-tasks', [SystemTaskController::class, 'index']);
        Route::get('/system-tasks/{id}', [SystemTaskController::class, 'show']);
        Route::post('/system-tasks/{id}/status', [SystemTaskController::class, 'taskStatus']);
    });


    Route::prefix('schedules')->group(function () {
        Route::get('/appointments', [AppointmentController::class, 'index']);
        Route::get('/appointments/{id}', [AppointmentController::class, 'show']);
        Route::post('/appointments', [AppointmentController::class, 'create']);
        Route::put('/appointments/{id}', [AppointmentController::class, 'update']);
        Route::delete('/appointments/{id}', [AppointmentController::class, 'delete']);
        Route::post('/appointments/{id}/cancel', [AppointmentController::class, 'cancel']);
    });


    // children
    Route::prefix('children')->group(function () {
        Route::get('/', [PatientController::class, 'index']);
        Route::get('/{id}', [PatientController::class, 'show']);
        Route::post('/', [PatientController::class, 'create']);
        Route::post('/{id}', [PatientController::class, 'update']);
        Route::delete('/{id}', [PatientController::class, 'delete']);
        Route::post('/{id}/generate-code', [PatientController::class, 'generateCode']);
    });


    Route::get('/doctors', [DoctorController::class, 'index']);
    Route::get('/doctors/{id}', [DoctorController::class, 'show']);


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
