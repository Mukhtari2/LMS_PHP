<?php

namespace App\Services;

use App\Models\Enrollment;
use App\Models\User;

class EnrollmentService {
    public function enrollStudent (User $user, $courseId){
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
    }
}
