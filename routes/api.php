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

// Protected Endpoints (Requires Bearer Token)
Route::middleware('auth:sanctum')->group(function () {
    Route::post('/admin/create-user', [AuthApiController::class, 'createUser']);
    Route::post('/course', [CourseApiController::class, 'store']);
    Route::get('/courses/{course}', [CourseApiController::class, 'show']);
    Route::put('/courses/{course}', [CourseApiController::class, 'update']);
    Route::delete('/courses/{course}', [CourseApiController::class, 'destroy']);
    Route::post('/enrollCourse', [EnrollmentApiController::class, 'store']);
    Route::post('/lesson', [LessonApiController::class, 'store']);
    Route::put('/lessons/{lesson}', [LessonApiController::class, 'update']);
    Route::post('/submission', [SubmissionApiController::class, 'store']);
    Route::put('/submissions/{submission}/grade', [SubmissionApiController::class, 'grade']);
    Route::post('/assignments', [AssignmentApiController::class, 'store']);
    Route::get('/assignments/{id}', [AssignmentApiController::class, 'show']);
    Route::put('/assignments/{assignment}', [AssignmentApiController::class, 'update']);
});

