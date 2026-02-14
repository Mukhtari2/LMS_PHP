<?php

namespace App\Services;

use App\Models\Submission;

use function Symfony\Component\Clock\now;

class SubmissionService {

public function createSubmission(array $data, $file = null){
    $filePath = null;

    if($file){
        $filePath = $file->store('submissions', 'public');
    }

    return Submission::updateOrCreate([
        'assignment_id' => $data['assignment_id'],
        'user_id'       => Auth::id(),
    ],
    [
        'student_id' => $data['student_id'],
        'file_url' => $filePath,
        'answered_at' => now(),
        'grade' => $data['grade'],
        'teacher_feedback' => $data['teacher_feedback'],
        'submitted_at' => now(),
        'submitted_at'  => now(),
    ]);

}

public function gradeSubmission(Submission $submission, int $grade, $feedback = null){
    return $submission->update([
        'grade' => $grade,
        'teacher_feedback' => $feedback,
    ]);
}

}

