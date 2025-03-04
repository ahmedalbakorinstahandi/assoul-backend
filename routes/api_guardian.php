<?php

use App\Http\Controllers\Health\BloodSugarReadingController;
use App\Http\Controllers\Health\InsulinDoseController;
use App\Http\Controllers\Health\MealController;
use App\Http\Controllers\Health\PhysicalActivityController;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\GuardianMiddleware;

Route::prefix('guardian')->middleware(['auth:sanctum', GuardianMiddleware::class])->group(function () {
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
});
