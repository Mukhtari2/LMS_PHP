<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Services\LessonService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LessonController extends Controller{

    protected $lessonService;

    public function __construct(LessonService $lessonService){
        $this -> lessonService = $lessonService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
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
        $request -> validate([
            'course_id' => 'required|exists:courses,id',
            'title' => 'required|string|max:225',
            'content_url' => 'required',
        ]);

        $course = Course::findorFail($request -> course_id);
        $user = Auth::user();

        if($user->id !== $course ->teacher_id){
            abort(403, 'Unauthorized action. You do not own this course.');
        }

        $this->lessonService -> createLesson($request-> all());
        return back()->with('status', 'Lesson added successfully!');

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
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
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
