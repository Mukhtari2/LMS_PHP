<?php

namespace App\Services;

use App\Models\Submission;
use Illuminate\Support\Facades\Auth;
use Exception;
use Illuminate\Support\Facades\Log; 

use function Symfony\Component\Clock\now;

class SubmissionService {

public function createSubmission(array $data, $file = null){
    try{
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
    } catch (Exception $exception){
        Log::error("Failed to update submission: ", $exception->getMessage());
        throw new Exception("Unable to update submission, please try again!");
    }

}

public function gradeSubmission(Submission $submission, int $grade, $feedback = null){
    try{
        return $submission->update([
        'grade' => $grade,
        'teacher_feedback' => $feedback,
        ]);
    } catch (Exception $exception){
        Log::error("unable to grade submiision: ", $exception->getMessage());
        throw new Exception("Faile to grade submision, please try again with the corect credentials");
    }
}

}

