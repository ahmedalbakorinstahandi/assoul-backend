<?php

use App\Http\Controllers\Notifications\NotificationController;
use Illuminate\Routing\Route;


Route::prefix('general')->middleware(['auth:sanctum'])->group(function () {
    Route::get('/notifications', [NotificationController::class, 'index']);
    Route::get('/notifications/{id}', [NotificationController::class, 'show']);
    Route::delete('/notifications/{id}', [NotificationController::class, 'destroy']);
});
