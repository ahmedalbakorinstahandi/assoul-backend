<?php

use App\Http\Controllers\Helth\BloodSugarReadingController;
use App\Http\Controllers\Users\AuthController;
use App\Http\Middleware\ChildMiddleware;
use App\Http\Middleware\GuardianMiddleware;
use App\Http\Middleware\ParentMiddleware;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::prefix('auth')->group(function () {
    Route::post('login', [AuthController::class, 'login']);
});

//child routes
Route::prefix('child')->middleware(['auth:sanctum', ChildMiddleware::class])->group(function () {
    Route::get('/blood-sugar-reading', [BloodSugarReadingController::class, 'index']);
    Route::get('/blood-sugar-reading/{id}', [BloodSugarReadingController::class, 'show']);
    Route::post('/blood-sugar-reading', [BloodSugarReadingController::class, 'create']);
    Route::put('/blood-sugar-reading/{id}', [BloodSugarReadingController::class, 'update']);
    Route::delete('/blood-sugar-reading/{id}', [BloodSugarReadingController::class, 'delete']);
});


// Guardian routes
Route::prefix('guardian')->middleware(['auth:sanctum', GuardianMiddleware::class])->group(function () {
    Route::get('/blood-sugar-reading', [BloodSugarReadingController::class, 'index']);
    Route::get('/blood-sugar-reading/{id}', [BloodSugarReadingController::class, 'show']);
    Route::post('/blood-sugar-reading', [BloodSugarReadingController::class, 'create']);
    Route::put('/blood-sugar-reading/{id}', [BloodSugarReadingController::class, 'update']);
    Route::delete('/blood-sugar-reading/{id}', [BloodSugarReadingController::class, 'delete']);
});
