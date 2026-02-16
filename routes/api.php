<?php

use App\Http\Controllers\Api\CourseApiController;
use Illuminate\Support\Facades\Route;

// Protected Endpoints (Requires Bearer Token)
Route::middleware('auth:sanctum')->group(function () {
    Route::post('/course', [CourseApiController::class, 'store']);             // Create
    Route::get('/courses/{course}', [CourseApiController::class, 'show']);      // Get one
    Route::put('/courses/{course}', [CourseApiController::class, 'update']);    // Update
    Route::delete('/courses/{course}', [CourseApiController::class, 'destroy']); // Delete
});

