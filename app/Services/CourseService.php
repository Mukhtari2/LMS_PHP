<?php

namespace App\Services;

use App\Models\Course;


class CourseService {
    public function createCourse(array $data){
        return Course::create([
            'title' => $data['title'],
            'description' => $data['description'],
            'teacher_id' => $data['teacher_id'],
            'is_published' => $data['is_published'] ?? false,
        ]);
    }

    public function updateCourse(Course $course, array $data){
        $course -> update($data);
        return $course;
    }

    public function getAllPublished(){
        return Course::where('is_published', true)
        ->with(['teacher', 'lessons'])
        ->latest()
        ->get();
    }

    public function deleteCourse(Course $course){
        return $course->delete();
    }
}
