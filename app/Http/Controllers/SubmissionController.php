<?php

namespace App\Http\Controllers;

use App\Models\Submission;
use App\Services\SubmissionService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SubmissionController extends Controller {
    protected $submissionService;

    public function __construct(SubmissionService $submissionService){
        $this->submissionService = $submissionService;
    }

    public function store(Request $request){
        $request->validate([
            'assignment_id' => 'required|exists:assignments,id',
            'student_id'    => 'required|exists:users,id',
            'file'          => 'nullable|file|mimes:pdf,doc,docx,zip|max:10240', // Max 10MB
            'content'       => 'nullable|string',
        ]);

        $this->submissionService->createSubmission(
            $request->all(),
            $request->file('file')
        );

        return back()->with('status', 'Assignment submitted successfully!');
    }

    public function update(Request $request, Submission $submission){
        if(Auth::id() !== $submission->Assignment->lesson->course->teacher_id){
            abort(403, 'You are not authorized to grade this submission.');
        }

        $request->validate([
            'grade'            => 'required|integer|min:0|max:100',
            'teacher_feedback' => 'nullable|string',
        ]);

        $this->submissionService->gradeSubmission(
            $submission,
            $request->grade,
            $request->teacher_feedback
        );

        return back()->with('status', 'Grade updated succesfully!');
    }
}
