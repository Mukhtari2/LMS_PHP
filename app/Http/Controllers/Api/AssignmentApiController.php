<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\AssignmentService;
use Illuminate\Http\Request;

class AssignmentApiController extends Controller
{
    protected $assignmentService;

    public function __construct(AssignmentService $assignmentService){
        $this->assignmentService =$assignmentService;
    }

}
