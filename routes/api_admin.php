<?php

use App\Http\Controllers\Games\AnswerController;
use App\Http\Controllers\Games\GameController;
use App\Http\Controllers\Games\LevelController;
use App\Http\Controllers\Games\QuestionController;
use App\Http\Controllers\General\EducationalContentController;
use App\Http\Controllers\General\ImageController;
use App\Http\Controllers\Health\BloodSugarReadingController;
use App\Http\Controllers\Health\InsulinDoseController;
use App\Http\Controllers\Health\MealController;
use App\Http\Controllers\Health\PhysicalActivityController;
use App\Http\Controllers\Notifications\NotificationController;
use App\Http\Controllers\Notifications\ScheduledNotificationController;
use App\Http\Controllers\Patients\InstructionController;
use App\Http\Controllers\Patients\MedicalRecordController;
use App\Http\Controllers\Patients\PatientNoteController;
use App\Http\Controllers\Schedules\AppointmentController;
use App\Http\Controllers\Tasks\SystemTaskController;
use App\Http\Controllers\Tasks\ToDoListController;
use App\Http\Controllers\Users\DoctorController;
use App\Http\Controllers\Users\GuardianController;
use App\Http\Controllers\Users\PatientController;
use App\Http\Middleware\AdminMiddlware;
use Illuminate\Support\Facades\Route;

Route::prefix('admin')->middleware(['auth:sanctum', AdminMiddlware::class])->group(function () {


    Route::prefix('games')->group(function () {
        Route::get('games', [GameController::class, 'index']);
        Route::get('games/{id}', [GameController::class, 'show']);
        Route::post('games', [GameController::class, 'create']);
        Route::put('games/{id}', [GameController::class, 'update']);
        Route::delete('games/{id}', [GameController::class, 'delete']);


        // Levels
        Route::get('levels', [LevelController::class, 'index']);
        Route::get('levels/{id}', [LevelController::class, 'show']);
        Route::post('levels', [LevelController::class, 'create']);
        Route::put('levels/{id}', [LevelController::class, 'update']);
        Route::delete('levels/{id}', [LevelController::class, 'delete']);

        // Questions
        Route::get('questions', [QuestionController::class, 'index']);
        Route::get('questions/{id}', [QuestionController::class, 'show']);
        Route::post('questions', [QuestionController::class, 'create']);
        Route::put('questions/{id}', [QuestionController::class, 'update']);
        Route::delete('questions/{id}', [QuestionController::class, 'delete']);

        //Answers
        Route::get('answers', [AnswerController::class, 'index']);
        Route::get('answers/{id}', [AnswerController::class, 'show']);
        Route::post('answers', [AnswerController::class, 'create']);
        Route::put('answers/{id}', [AnswerController::class, 'update']);
        Route::delete('answers/{id}', [AnswerController::class, 'delete']);
    });


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


    // general routes
    Route::prefix('general')->group(function () {
        Route::post('upload-image', [ImageController::class, 'uploadImage']);

        //EducationalContentController
        Route::get('educational-contents', [EducationalContentController::class, 'index']);
        Route::get('educational-contents/{id}', [EducationalContentController::class, 'show']);
        Route::post('educational-contents', [EducationalContentController::class, 'create']);
        Route::put('educational-contents/{id}', [EducationalContentController::class, 'update']);
        Route::delete('educational-contents/{id}', [EducationalContentController::class, 'delete']);
    });


    Route::prefix('notifications')->group(function () {
        Route::get('/scheduled-notifications', [ScheduledNotificationController::class, 'index']);
        Route::get('/scheduled-notifications/{id}', [ScheduledNotificationController::class, 'show']);
        Route::post('/scheduled-notifications', [ScheduledNotificationController::class, 'create']);
        Route::put('/scheduled-notifications/{id}', [ScheduledNotificationController::class, 'update']);
        Route::delete('/scheduled-notifications/{id}', [ScheduledNotificationController::class, 'delete']);


        Route::get('/notifications', [NotificationController::class, 'index']);
        Route::get('/notifications/{id}', [NotificationController::class, 'show']);
        Route::delete('/notifications/{id}', [NotificationController::class, 'destroy']);
        Route::post('/notifications/{id}/read', [NotificationController::class, 'readNotification']);
        Route::get('/notifications/unread-count', [NotificationController::class, 'getNotificationsUnreadCount']);
    });

    Route::prefix('tasks')->group(function () {
        Route::get('/system-tasks', [SystemTaskController::class, 'index']);
        Route::get('/system-tasks/{id}', [SystemTaskController::class, 'show']);
        Route::post('/system-tasks', [SystemTaskController::class, 'create']);
        Route::put('/system-tasks/{id}', [SystemTaskController::class, 'update']);
        Route::delete('/system-tasks/{id}', [SystemTaskController::class, 'delete']);


        Route::get('/to-do-list', [ToDoListController::class, 'index']);
        Route::get('/to-do-list/{id}', [ToDoListController::class, 'show']);
        Route::post('/to-do-list', [ToDoListController::class, 'create']);
        Route::put('/to-do-list/{id}', [ToDoListController::class, 'update']);
        Route::delete('/to-do-list/{id}', [ToDoListController::class, 'delete']);
        Route::post('/to-do-list/{id}/check', [ToDoListController::class, 'check']);
    });

    Route::prefix('schedules')->group(function () {
        Route::get('/appointments', [AppointmentController::class, 'index']);
        Route::get('/appointments/{id}', [AppointmentController::class, 'show']);
        Route::post('/appointments', [AppointmentController::class, 'create']);
        Route::put('/appointments/{id}', [AppointmentController::class, 'update']);
        Route::delete('/appointments/{id}', [AppointmentController::class, 'delete']);
        Route::post('/appointments/{id}/cancel', [AppointmentController::class, 'cancel']);
    });

    // users
    Route::prefix('users')->group(function () {
        Route::get('/children', [PatientController::class, 'index']);
        Route::get('/children/{id}', [PatientController::class, 'show']);
        Route::post('/children', [PatientController::class, 'create']);
        Route::post('/children/{id}', [PatientController::class, 'update']);
        Route::delete('/children/{id}', [PatientController::class, 'delete']);
        Route::post('/children/{id}/generate-code', [PatientController::class, 'generateCode']);


        //GuardianController
        Route::get('/guardians', [GuardianController::class, 'index']);
        Route::get('/guardians/{id}', [GuardianController::class, 'show']);
        Route::post('/guardians', [GuardianController::class, 'create']);
        Route::put('/guardians/{id}', [GuardianController::class, 'update']);
        Route::delete('/guardians/{id}', [GuardianController::class, 'delete']);

        Route::get('/doctors', [DoctorController::class, 'index']);
        Route::get('/doctors/{id}', [DoctorController::class, 'show']);
        Route::post('/doctors', [DoctorController::class, 'create']);
        Route::put('/doctors/{id}', [DoctorController::class, 'update']);
        Route::delete('/doctors/{id}', [DoctorController::class, 'delete']);
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
