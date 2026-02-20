<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Enrollment;
use App\Services\EnrollmentService;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Exception;

class EnrollmentApiController extends Controller {
    protected $enrollementService;

    public function __construct(EnrollmentService $enrollmentService){
        $this->enrollementService = $enrollmentService;
    }

    public function store (Request $request): JsonResponse{
        $request->validate([
            'course_id' => 'required',
        ]);
        try{
            $enrollment = $this->enrollementService->enrollStudent(
                $request->user(),
                $request->course_id
            );

            return response()->json([
                'status' => 'success',
                'message' => $enrollment->message,
                'data' =>$enrollment
            ], 201);
        } catch (Exception $e){
            return response()->json([
            'status' => 'error',
            'message' => $e->getMessage()
            ], 404);
        }
        
    }

}

