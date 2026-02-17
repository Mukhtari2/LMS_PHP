<?php
use App\Http\Controllers\Api\AuthApiController;
use App\Http\Controllers\Api\CourseApiController;
use App\Http\Controllers\Api\EnrollmentApiController;
use App\Http\Controllers\Api\LessonApiController;
use Illuminate\Support\Facades\Route;
use Symfony\Component\HttpKernel\HttpCache\Store;

Route::post('/login', [AuthApiController::class, 'login']);

// Protected Endpoints (Requires Bearer Token)
Route::middleware('auth:sanctum')->group(function () {
    Route::post('/admin/create-user', [AuthApiController::class, 'createUser']);
    Route::post('/course', [CourseApiController::class, 'store']);
    Route::get('/courses/{course}', [CourseApiController::class, 'show']);
    Route::put('/courses/{course}', [CourseApiController::class, 'update']);
    Route::delete('/courses/{course}', [CourseApiController::class, 'destroy']);
    Route::post('/enrollCourse', [EnrollmentApiController::class, 'store']);
    Route::post('/writeLessonNote', [LessonApiController::class, 'store']);
});

