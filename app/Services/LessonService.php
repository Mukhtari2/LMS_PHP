<?php

namespace App\Services;

use App\Models\Lesson;

class LessonService {
    public function createLesson(array $data){
        return Lesson::create([
            'course_id' => $data ['course_id'],
            'title' => $data['title'],
            'content_url' => $data['content_url'] ?? null,
        ]);
    }

    public function updateLesson(Lesson $lesson, array $data){
        $lesson -> update($data);
        return$lesson;
    }
}
