<?php
use App\Http\Controllers\Api\AuthApiController;
use App\Http\Controllers\Api\AssignmentApiController;
use App\Http\Controllers\Api\CourseApiController;
use App\Http\Controllers\Api\EnrollmentApiController;
use App\Http\Controllers\Api\LessonApiController;
use App\Http\Controllers\Api\SubmissionApiController;
use Illuminate\Support\Facades\Route;
use Symfony\Component\HttpKernel\HttpCache\Store;

Route::post('/login', [AuthApiController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {

    Route::middleware('role:admin')->group(function () {
        Route::post('/admin/create-user', [AuthApiController::class, 'createUser']);
    });

    Route::middleware('role:teacher')->group(function () {
        Route::post('courses', [CourseApiController::class, 'store']);
        Route::put('courses/{course}', [CourseApiController::class, 'update']);
        Route::delete('courses/{course}', [CourseApiController::class, 'destroy']);
        Route::post('lessons', [LessonApiController::class, 'store']);
        Route::put('lessons/{lesson}', [LessonApiController::class, 'update']);
        Route::post('assignments', [AssignmentApiController::class, 'store']);
        Route::put('submissions/{submission}/grade', [SubmissionApiController::class, 'grade']);
    });

    Route::middleware('role:student')->group(function () {
        Route::get('courses/{course}', [CourseApiController::class, 'show']);
        Route::post('enroll', [EnrollmentApiController::class, 'store']);
        Route::post('submissions', [SubmissionApiController::class, 'store']);
        Route::get('assignments/{id}', [AssignmentApiController::class, 'show']);
    });
});
