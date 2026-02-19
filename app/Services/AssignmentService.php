<?php

namespace App\Services;

use App\Models\Assignment;
use Carbon\Carbon;

class AssignmentService{
    public function createAssignment(array $data){
        return Assignment::create([
            'course_id' => $data['course_id'],
            'title' => $data['title'],
            'description' => $data['description'],
            'due_date' => Carbon::parse($data['due_date']),
        ]);
    }

    public function updateAssignment(Assignment $assignment, array $data){
        if(isset($data['due_date'])){
            $data['due_date'] =Carbon::parse($data['due_date']);
        }
        $assignment->update($data);
        return $assignment;
    }

    public function getAssignmentDetails(string $id){
        return Assignment::with([
            'course',
            'submissions.user'
        ])->findOrFail($id);
    }

}
