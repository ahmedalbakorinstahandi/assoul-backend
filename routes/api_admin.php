<?php

use App\Http\Controllers\Games\GameController;
use App\Http\Controllers\Games\LevelController;
use App\Http\Controllers\Games\QuestionController;
use App\Http\Controllers\General\ImageController;
use App\Http\Middleware\AdminMiddlware;
use Illuminate\Support\Facades\Route;

Route::prefix('admin')->middleware(['auth:sanctum', AdminMiddlware::class])->group(function () {

    Route::post('upload-image', [ImageController::class, 'uploadImage']);

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
    });
});
