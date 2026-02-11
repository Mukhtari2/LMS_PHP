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
            return "Welcome to Course" ;
        }

        return $enrollment;
    }
}
