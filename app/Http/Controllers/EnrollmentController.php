<?php

namespace App\Http\Controllers;

use App\Services\EnrollmentService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EnrollmentController extends Controller {
    protected $enrollmentService;

    public function __construct(EnrollmentService $enrollmentService){
        $this->enrollmentService = $enrollmentService;

    }

    public function store(Request $request){

        $request -> validate([
            'course_id' => 'required|exists:courses,id'
        ]);

        $user = Auth::user();
        $enrollment = $this -> enrollmentService ->enrollStudent(
            $user,
            $request -> course_id);

        return back() ->with('status', $enrollment -> message);
    }
}
