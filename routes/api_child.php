<?php

use App\Http\Controllers\Games\GameController;
use App\Http\Controllers\Games\LevelController;
use App\Http\Controllers\Games\QuestionController;
use App\Http\Controllers\General\EducationalContentController;
use App\Http\Controllers\Health\BloodSugarReadingController;
use App\Http\Controllers\Health\InsulinDoseController;
use App\Http\Controllers\Health\MealController;
use App\Http\Controllers\Health\PhysicalActivityController;
use App\Http\Controllers\Notifications\NotificationController;
use App\Http\Controllers\Notifications\ScheduledNotificationController;
use App\Http\Controllers\Tasks\SystemTaskController;
use App\Http\Controllers\Tasks\ToDoListController;
use App\Http\Controllers\Users\PatientController;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\ChildMiddleware;

Route::prefix('child')->middleware(['auth:sanctum', ChildMiddleware::class])->group(function () {

    Route::get('/profile', [PatientController::class, 'getPatientData']);
    Route::post('/profile/avatar', [PatientController::class, 'updateAvatar']);
    Route::get('/home', [PatientController::class, 'getHomeData']);


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

    Route::prefix('games')->group(function () {
        Route::get('/games', [GameController::class, 'index']);
        Route::get('/games/{id}', [GameController::class, 'show']);

        Route::get('/levels', [LevelController::class, 'index']);
        Route::get('/levels/{id}', [LevelController::class, 'show']);
        Route::get('/levels/{id}/next-question', [LevelController::class, 'getNextQuestion']);

        Route::post('/questions/next', [QuestionController::class, 'getNextQuestion']);
        Route::post('/questions/{id}/answer', [QuestionController::class, 'answerQuestion']);
    });


    // general 
    Route::prefix('general')->group(function () {
        Route::get('/educational-contents', [EducationalContentController::class, 'index']);
        Route::get('/educational-contents/{id}', [EducationalContentController::class, 'show']);
    });

    // notifications
    Route::prefix('notifications')->group(function () {
        Route::get('/scheduled-notifications', [ScheduledNotificationController::class, 'index']);
        Route::get('/scheduled-notifications/{id}', [ScheduledNotificationController::class, 'show']);
        Route::post('/emergency', [NotificationController::class, 'sendEmergencyNotification']);
    });


    // tasks
    Route::prefix('tasks')->group(function () {
        Route::get('/system-tasks', [SystemTaskController::class, 'index']);
        Route::get('/system-tasks/{id}', [SystemTaskController::class, 'show']);
        Route::post('/system-tasks/{id}/status', [SystemTaskController::class, 'taskStatus']);


        Route::get('/to-do-list', [ToDoListController::class, 'index']);
        Route::get('/to-do-list/{id}', [ToDoListController::class, 'show']);
        Route::post('/to-do-list/{id}/check', [ToDoListController::class, 'check']);
    });
});
