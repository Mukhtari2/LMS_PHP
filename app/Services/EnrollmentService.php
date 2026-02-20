<?php

namespace App\Services;

use App\Models\Enrollment;
use App\Models\User;
use App\Models\Course;
use Illuminate\Support\Facades\Log; 
use Exception;

class EnrollmentService {
    public function enrollStudent (User $user, $courseId){
        try{
            if(!Course::where('id', $courseId)->exists()){
                throw new Exception("Course not found.");
            }

            $enrollment = Enrollment::firstOrCreate([
                'user_id' => $user -> id,
                'course_id' => $courseId,
            ],
            [
                'enrolled_at' => now(),
            ]);
    

            if($enrollment -> wasRecentlyCreated){
                $enrollment -> message = "Welcome to the Course!" ;
            }else{
                $enrollment -> message = "You are already enrolled in this course";
            }

            return $enrollment;

        } catch (Exception $exception) {
             Log::error("General Enrollment Error: " . $exception->getMessage());
             throw new Exception($exception->getMessage());
        }
    }
}
