<?php

namespace App\Http\Controllers;

use App\Services\CourseService;

class CourseController {
    protected $courseService;

    public function __construct(CourseService $courseService){
        $this->courseService = $courseService;
    }

    public function store(Request $request){
        $request -> validate([
            'teacher_id' => 'required|exist:teacher,id',
            'title' => 'required|string|max:220',
            'description' => 'required|string|max:220',
            'is_published' => 
        ]);

        $courseService = $this->courseService->createCourse(

        )

    }

}
