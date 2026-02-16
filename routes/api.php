<?php
use App\Http\Controllers\Api\AuthApiController;
use App\Http\Controllers\Api\CourseApiController;
use Illuminate\Support\Facades\Route;

Route::post('/login', [AuthApiController::class, 'login']);

// Protected Endpoints (Requires Bearer Token)
Route::middleware('auth:sanctum')->group(function () {
    Route::post('/admin/create-user', [AuthApiController::class, 'createUser']);
    Route::post('/course', [CourseApiController::class, 'store']);             // Create
    Route::get('/courses/{course}', [CourseApiController::class, 'show']);      // Get one
    Route::put('/courses/{course}', [CourseApiController::class, 'update']);    // Update
    Route::delete('/courses/{course}', [CourseApiController::class, 'destroy']); // Delete
});

