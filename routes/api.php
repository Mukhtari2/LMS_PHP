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
    Route::post('teacher/course', [CourseApiController::class, 'store']);
    Route::get('student/courses/{course}', [CourseApiController::class, 'show']);
    Route::put('teacher/courses/{course}', [CourseApiController::class, 'update']);
    Route::delete('teacher/courses/{course}', [CourseApiController::class, 'destroy']);
    Route::post('student/enrollCourse', [EnrollmentApiController::class, 'store']);
    Route::post('teacher/lesson', [LessonApiController::class, 'store']);
    Route::put('teacher/lessons/{lesson}', [LessonApiController::class, 'update']);
    Route::post('student/submission', [SubmissionApiController::class, 'store']);
    Route::put('teacher/submissions/{submission}/grade', [SubmissionApiController::class, 'grade']);
    Route::post('teacher/assignments', [AssignmentApiController::class, 'store']);
    Route::get('student/assignments/{id}', [AssignmentApiController::class, 'show']);
    Route::put('student/assignments/{assignment}', [AssignmentApiController::class, 'update']);
});

