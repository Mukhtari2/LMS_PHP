<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\SubmissionService;
use Illuminate\Http\Request;

class SubmisionApiController extends Controller
{
    protected $submissionService;

    public function __construct(SubmissionService $submissionService){
        $this->submissionService = $submissionService;
    }

}
