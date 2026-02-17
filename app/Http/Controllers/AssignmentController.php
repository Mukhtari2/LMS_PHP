<?php

namespace App\Http\Controllers;

use App\Models\Assignment;
use App\Models\Lesson;
use App\Services\AssignmentService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AssignmentController extends Controller {
    protected $assignmentService;

    public function __construct(AssignmentService $assignmentService){
        $this->assignmentService = $assignmentService;
    }


    public function index(Lesson $lesson){
        $assignments = $lesson->assignments;
        return view('assignments.index', compact('assignments', 'lesson'));
    }



    public function create()
    {
        //
    }


    public function store(Request $request){
        $request->validate([
            'course_id' => 'required|string|max:225',
            'title' => 'required|string|max:225',
            'description' => 'required|string|max:225',
            'due_date' => 'required|date|after:today',
        ]);

        $this->assignmentService->createAssignment($request->all());

        return back()->with('status', 'Assignment created successfully');
    }


    public function show(string $id){
        $assignment = $this->assignmentService->getAssignmentDetails($id);

        $user = Auth::user();


        $userSubmission = $assignment->submissions()->where('user_id', $user->id)->first();
        return view('assignment.show', [
            'assignment' => $assignment,
            'isTeacher' => $user->id === $assignment->lesson->course->teacher_id,
            'userSubmission' => $userSubmission
        ]);

    }


    public function edit(string $id)
    {
        //
    }

    public function update(Request $request, Assignment $assignment){
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'instructions' => 'required|string|max:255',
            'due_date' => 'required|date|after:now',
        ]);

        $this->assignmentService->updateAssignment($assignment, $validated);

        return back()->with('status', 'Assignment updated successfully!');
    }


    public function destroy(string $id)
    {
        //
    }
}
