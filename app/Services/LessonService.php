<?php

namespace App\Services;

use App\Models\Lesson;
use Exception;
use Illuminate\Support\Facades\Log; 

class LessonService {
    public function createLesson(array $data){
        try{
            return Lesson::create([
                'course_id' => $data ['course_id'],
                'title' => $data['title'],
                'content_url' => $data['content_url'] ?? null,
            ]);
        } catch (Exception $e){
            Log::error("Creating lesson failed");
            throw new Exception("Failed to create lesson, please try again");
        }
    }

    public function updateLesson(Lesson $lesson, array $data){
        try{
            $lesson -> update($data);
            return $lesson;
        } catch (Exception $e){
            Log::error("update lesson failed");
            throw new Exception("this operation failed maybe due to invalid credential provided");
        }
    }
}
