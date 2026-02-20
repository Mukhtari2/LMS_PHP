<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Services\CourseService;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Exception;

class CourseApiController extends Controller {
    protected $courseService;

    public function __construct(CourseService $courseService) {
        $this->courseService = $courseService;
    }

    public function index(): JsonResponse {
        try{
            $courses = $this->courseService->getAllPublished();
            return response()->json([
                'success' => true,
                'count' => $courses->count(),
                'data' => $courses
            ], 200);
        } catch (Exception $e){
            return response()->json([
                'success' => false,
                'message' => 'Failed to retrieve courses.'
            ], 500);
        }
    }

    public function store(Request $request): JsonResponse {
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'is_published' => 'nullable|boolean',
            'teacher_id' => 'required|exists:users,id']);

        try{
            $course = $this->courseService->createCourse($data);
            return response()->json([
                'status' => 'success',
                'message' => 'Course created successfully!',
                'data' => $course
            ], 201);
        } catch (Exception $e){
            return response()->json([
                'status' => 'error',
                'message' => 'could not create course, please try again'
            ], 500);
        }

    }

    public function update(Request $request, Course $course): JsonResponse{
        $data =$request->validate([
            'title' => 'sometimes|string|max:255',
            'description' => 'sometimes|string',
            'is_published' => 'sometimes|boolean'
        ]);

        $updatedCourse = $this->courseService->updateCourse($course, $data);
        return response()->json($updatedCourse);
    }

    public function destroy(Course $course){
        $this->courseService->deleteCourse($course);
        return response()->json(['message' =>'Course deleted successfully'], 200);
    }
}

