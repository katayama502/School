<?php

use App\Http\Controllers\API\AssignmentController;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\CourseController;
use App\Http\Controllers\API\DashboardController;
use App\Http\Controllers\API\LessonController;
use App\Http\Controllers\API\ProgressController;
use App\Http\Controllers\API\RunnerController;
use App\Http\Controllers\API\ScratchProjectController;
use App\Http\Controllers\API\SubmissionController;
use Illuminate\Support\Facades\Route;

Route::prefix('v1')->group(function () {
    Route::post('/auth/login', [AuthController::class, 'login']);
    Route::post('/auth/logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');
    Route::get('/auth/me', [AuthController::class, 'me'])->middleware('auth:sanctum');

    Route::middleware('auth:sanctum')->group(function () {
        Route::get('/courses', [CourseController::class, 'index']);
        Route::get('/lessons/{lesson}', [LessonController::class, 'show']);
        Route::get('/assignments', [AssignmentController::class, 'index']);

        Route::get('/submissions', [SubmissionController::class, 'index']);
        Route::post('/submissions', [SubmissionController::class, 'store']);
        Route::put('/submissions/{submission}', [SubmissionController::class, 'update']);
        Route::get('/submissions/{submission}/runs', [SubmissionController::class, 'runs']);

        Route::post('/runner/execute', [RunnerController::class, 'execute']);

        Route::post('/scratch/projects', [ScratchProjectController::class, 'store']);
        Route::put('/scratch/projects/{project}', [ScratchProjectController::class, 'update']);
        Route::get('/scratch/projects/{project}', [ScratchProjectController::class, 'show']);

        Route::get('/progress', [ProgressController::class, 'index']);
        Route::get('/dashboard', [DashboardController::class, 'index']);
    });
});
