<?php

namespace App\Services

use App\Enums\CourseStatus;
use App\Models\Course;
use Illuminate\Support\Facades\Auth;


class CourseService {
    public function createCourse(array $data){

        return Course::create([
            'title' => $data['title'],
            'description' => $data ['description'],
            'teacher_id' => Auth::id(),
            'is_published' => $data ['status'] === CourseStatus::PUBLISHED -> value,
        ]);
    }

}
