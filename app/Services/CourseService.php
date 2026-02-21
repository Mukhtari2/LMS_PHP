<?php

namespace App\Services;

use App\Models\Course;
use Exception;
use Illuminate\Support\Facades\Log; 


class CourseService {
    public function createCourse(array $data){
            try {
                return Course::create([
                    'title' => $data['title'],
                    'description' => $data['description'],
                    'teacher_id' => $data['teacher_id'],
                    'is_published' => $data['is_published'] ?? false,
                ]);
            } catch (Exception $e) {
                Log::error("Course Creation Failed: " . $e->getMessage());
                throw new Exception("Unable to create course. Please verify your data.");
            }
    }

    public function updateCourse(Course $course, array $data){
        try{
            $course -> update($data);
            return $course;
        } catch (Exception $e) {
            Log::error("Course Update Failed ID {$course->id}: " . $e->getMessage());
            throw new Exception("Failed to update the course.");
        }
    }

    public function getAllPublished(){
        try{
            return Course::where('is_published', true)
            ->with(['teacher', 'lessons'])
            ->latest()
            ->get();
        } catch (Exception $e) {
            Log::error("Fetch Published Courses Failed: " . $e->getMessage());
            return collect();
        }
    }

    public function deleteCourse(Course $course){
        try{
            return $course->delete();
        } catch (Exception $e) {
            Log::error("Course Deletion Failed ID {$course->id}: " . $e->getMessage());
            throw new Exception("This course cannot be deleted. It may have active enrollments.");
        }
    }
}
