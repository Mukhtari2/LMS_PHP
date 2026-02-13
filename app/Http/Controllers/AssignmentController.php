<?php

namespace App\Http\Controllers;

use App\Models\Assignment;
use App\Services\AssignmentService;
use Illuminate\Http\Request;

class AssignmentController extends Controller{
    protected $assignmentService;

    public function __construct(AssignmentService $assignmentService){
        $this->assignmentService = $assignmentService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Lesson $lesson){
        $assignments = $lesson->assignments;
        return view('assignments.index', compact('assignments', 'lesson'));
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
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

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Assignment $assignment){
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'instructions' => 'required|string|max:255',
            'due_date' => 'required|date|after:now',
        ]);

        $this->assignmentService->updateAssignment($assignment, $validated);

        return back()->with('status', 'Assignment updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
