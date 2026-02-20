<?php

namespace App\Services;

use App\Models\Assignment;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Exception;

class AssignmentService{
    public function createAssignment(array $data){
        try{
            return Assignment::create([
                'course_id' => $data['course_id'],
                'title' => $data['title'],
                'description' => $data['description'],
                'due_date' => Carbon::parse($data['due_date']),
            ]);
        } catch (Exception $e) {
            Log::error("Assignment Creation Failed: " . $e->getMessage());
            throw new Exception($e->getMessage());
        }
    }

    public function updateAssignment(Assignment $assignment, array $data){
        try{
            if(isset($data['due_date'])){
                $data['due_date'] =Carbon::parse($data['due_date']);
            }
            $assignment->update($data);
            return $assignment;
        } catch(Exception $e) {
            Log::error("Assignment Update Failed ID {$assignment->id}: " . $e->getMessage());
            throw new Exception($e->getMessage());
        }
    }

    public function getAssignmentDetails(string $id){
        try{
            return Assignment::with([
                'course',
                'submissions.user'
            ])->findOrFail($id);
        } catch (ModelNotFoundException $e) {
            Log::error("Assignment View Failed: ID {$id} not found.");
            throw new Exception("Assignment not found.");
        } catch (Exception $e) {
            Log::error("General Assignment Error: " . $e->getMessage());
            throw new Exception("An error occurred while fetching assignment details.");
        }
    }

}
