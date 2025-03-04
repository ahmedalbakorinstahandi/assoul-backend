<?php

use App\Http\Controllers\Health\BloodSugarReadingController;
use App\Http\Controllers\Health\InsulinDoseController;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\ChildMiddleware;

Route::prefix('child')->middleware(['auth:sanctum', ChildMiddleware::class])->group(function () {
    Route::prefix('health')->group(function () {
        Route::get('/blood-sugar-reading', [BloodSugarReadingController::class, 'index']);
        Route::get('/blood-sugar-reading/{id}', [BloodSugarReadingController::class, 'show']);
        Route::post('/blood-sugar-reading', [BloodSugarReadingController::class, 'create']);
        Route::put('/blood-sugar-reading/{id}', [BloodSugarReadingController::class, 'update']);
        Route::delete('/blood-sugar-reading/{id}', [BloodSugarReadingController::class, 'delete']);


        Route::get('/insulin-dose', [InsulinDoseController::class, 'index']);
        Route::get('/insulin-dose/{id}', [InsulinDoseController::class, 'show']);
        Route::post('/insulin-dose', [InsulinDoseController::class, 'create']);
        Route::put('/insulin-dose/{id}', [InsulinDoseController::class, 'update']);
        Route::delete('/insulin-dose/{id}', [InsulinDoseController::class, 'delete']);
    });
});
