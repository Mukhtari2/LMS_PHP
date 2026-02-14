<?php

namespace App\Http\Controllers;

use App\Models\Submission;
use App\Services\SubmissionService;
use Illuminate\Http\Request;

class SubmissionController extends Controller {
    protected $submissionService;

    public function __construct(SubmissionService $submissionService){
        $this->submissionService = $submissionService;
    }

    public function store(Request $request){
        $request->validate([
            'assignment_id' => 'required|exists:assignments,id',
            'content'       => 'nullable|string',
            'file'          => 'nullable|file|mimes:pdf,zip,doc,docx|max:10240', // Max 10MB
        ]);

        $this->submissionService->submitAssignment(
        $request->only('assignment_id', 'content'),
        $request->file('file')
    );

    return back()->with('status', 'Assignment submitted successfully!');
}
}
