<?php

use App\Http\Controllers\Notifications\NotificationController;
use Illuminate\Support\Facades\Route;


Route::prefix('general')->middleware(['auth:sanctum'])->group(function () {
    Route::get('/notifications/unread-count', [NotificationController::class, 'getNotificationsUnreadCount']);
    Route::get('/notifications', [NotificationController::class, 'index']);
    Route::get('/notifications/{id}', [NotificationController::class, 'show']);
    Route::delete('/notifications/{id}', [NotificationController::class, 'destroy']);
    Route::post('/notifications/{id}/read', [NotificationController::class, 'readNotification']);
});
