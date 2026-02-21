<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Submission;
use App\Services\SubmissionService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;


class SubmissionApiController extends Controller {

    protected $submissionService;

    public function __construct(SubmissionService $submissionService){
        $this->submissionService = $submissionService;
    }

    public function store(Request $request): JsonResponse {
        $data = $request->validate([
            'assignment_id'    => 'required|exists:assignments,id',
            'student_id'       => 'required|exists:users,id',
            'file'             => 'nullable|file|mimes:pdf,zip,doc,docx|max:5120',
            'grade'            => 'nullable|integer',
            'teacher_feedback' => 'nullable|string',
        ]);


        try{
            $submission = $this->submissionService->createSubmission(
                $data,
                $request->file('file')
            );

            return response()->json([
                'status' => 'success',
                'message' => 'Assignment submitted successfully!',
                'data' => $submission
            ], 201);
        } catch (Exception $e){
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage(),
            ], 400);
        }
    }

    public function grade(Request $request, Submission $submission): JsonResponse {
        $request->validate([
            'grade'    => 'required|integer|min:0|max:100',
            'feedback' => 'nullable|string'
        ]);

        try{
            $this->submissionService->gradeSubmission(
                $submission,
                $request->grade,
                $request->feedback
            );

            return response()->json([
                'status' => 'success',
                'message' => 'Submission graded successfully!',
                'data' => $submission->fresh()
            ], 200);
        } catch (Exception $e){
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage(),
            ], 400);
        }
    }
}
