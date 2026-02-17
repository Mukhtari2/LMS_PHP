<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\LessonService;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class LessonApiController extends Controller {
    protected $lessonService;

    public function __construct(LessonService $lessonService){
        $this->lessonService = $lessonService;
    }

    public function store(Request $request): JsonResponse {
        $data = $request->validate([
            'course_id' => 'required|exists:courses,id',
            'title' => 'required|string|max:225',
            'content_url' => 'nullable|string|max:225'
        ]);
        $lesson = $this->lessonService->createLesson($data);

        return response()->json([
            'status' => 'success',
            'message' => 'Lesson created successfully!',
            'data' => $lesson], 201
        );
    }

    public function update(Request $request, Lesson $lesson): JsonResponse {
        $data = $request->validate([
            'title'       => 'sometimes|string|max:225',
            'content_url' => 'sometimes|string|max:225',
            'course_id'   => 'sometimes|exists:courses,id'
        ]);

        $updatedLesson = $this->lessonService->updateLesson($lesson, $data);

        return response()->json([
            'status' => 'success',
            'message' => 'Lesson updated successfully!',
            'data' => $updatedLesson
        ], 200);
    }

}
