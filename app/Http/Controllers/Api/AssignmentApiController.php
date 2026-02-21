<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Assignment;
use App\Services\AssignmentService;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Exception;

class AssignmentApiController extends Controller
{
    protected $assignmentService;

    public function __construct(AssignmentService $assignmentService)
    {
        $this->assignmentService = $assignmentService;
    }

    public function store(Request $request): JsonResponse
    {
        $data = $request->validate([
            'course_id'   => 'required|exists:courses,id',
            'title'       => 'required|string|max:255',
            'description' => 'required|string',
            'due_date'    => 'required|date|after:now',
        ]);

        try{
            $assignment = $this->assignmentService->createAssignment($data);

            return response()->json([
                'status' => 'success',
                'message' => 'Assignment created successfully!',
                'data' => $assignment
            ], 201);
        } catch (Exception $exception) {
            return response()->json([
                'status' => 'error',
                'message' => 'create assignment failed'
            ], 400);
        }
    }


    public function show(string $id): JsonResponse
    {
        try{
            $assignment = $this->assignmentService->getAssignmentDetails($id);

            return response()->json([
                'status' => 'success',
                'data' => $assignment
            ], 200);
        } catch (Exception $exception) {
            return response()->json([
                'status' => 'error',
                'message' => 'create assignment failed'
            ], 400);
        }
    }

 
    public function update(Request $request, Assignment $assignment): JsonResponse
    {
        $data = $request->validate([
            'title'       => 'sometimes|string|max:255',
            'description' => 'sometimes|string',
            'due_date'    => 'sometimes|date',
            'course_id'   => 'sometimes|exists:courses,id'
        ]);
        try{
            $updatedAssignment = $this->assignmentService->updateAssignment($assignment, $data);

            return response()->json([
                'status' => 'success',
                'message' => 'Assignment updated successfully!',
                'data' => $updatedAssignment
            ], 200);
        } catch (Exception $exception) {
            return response()->json([
                'status' => 'error',
                'message' => 'update assignment failed'
            ], 400);
        }
    }
}
