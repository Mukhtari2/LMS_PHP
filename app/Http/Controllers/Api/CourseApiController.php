<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Services\CourseService;
use Illuminate\Http\Request;

class CourseApiController extends Controller {
    protected $courseService;

    public function __construct(CourseService $courseService) {
        $this->courseService = $courseService;
    }

    public function index() {
        return response()->json($this->courseService->getAllPublished());
    }

    public function store(Request $request) {
        $data = $request->validate(['title' => 'required', 'description' => 'required']);
        $course = $this->courseService->createCourse($data);

        return response()->json([
            'message' => 'Course created via API!',
            'data' => $course
        ], 201);
    }
}

