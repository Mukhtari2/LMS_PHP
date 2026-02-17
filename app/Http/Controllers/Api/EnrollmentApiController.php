<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Enrollment;
use App\Services\EnrollmentService;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\JsonResponse;

class EnrollmentApiController extends Controller {
    protected $enrollementService;

    public function __construct(EnrollmentService $enrollmentService){
        $this->enrollementService = $enrollmentService;
    }

    public function store (Request $request): JsonResponse{
        $request->validate([
            'course_id' => 'required|exists:courses,id',
        ]);

        $enrollment = $this->enrollementService->enrollStudent(
            $request->user(),
            $request->course_id
        );

        return response()->json([
            'status' => 'success',
            'message' => $enrollment->message,
            'data' =>$enrollment
        ], 201);
    }

}

