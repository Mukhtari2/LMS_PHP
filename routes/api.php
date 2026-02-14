<?php

use App\Http\Controllers\Api\CourseApiController;
use App\Http\Controllers\Api\EnrollmentApiController;
use Illuminate\Support\Facades\Route;

// Public Endpoints
Route::get('/courses', [CourseApiController::class, 'index']); // Get all courses

// Protected Endpoints (Requires Bearer Token)
Route::middleware('auth:sanctum')->group(function () {
    Route::post('/courses', [CourseApiController::class, 'store']);       // Create course
    Route::get('/courses/{id}', [CourseApiController::class, 'show']);    // Get one course
    Route::post('/enroll', [EnrollmentApiController::class, 'store']);    // Enroll in course
});
