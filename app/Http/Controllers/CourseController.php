<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Services\CourseService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;


class CourseController extends Controller {
    protected $courseService;

    public function __construct(CourseService $courseService){
        $this->courseService = $courseService;
    }


    public function index(){
        $courses = $this->courseService->getAllPublished();
        return view('courses.index', compact('courses'));
    }

    public function store(Request $request){
        $request -> validate([
            'teacher_id' => 'required|exists:users,id',
            'title' => 'required|string|max:220',
            'description' => 'required|string|max:220',
        ]);

        $this->courseService->createCourse($request->all());

        return Redirect()->route('dashboard')->with('status', 'Course created successfully!');
    }

    public function show (Course $course){
        $course->load('lessons');
        return view('courses.show', compact('course'));
    }



}


