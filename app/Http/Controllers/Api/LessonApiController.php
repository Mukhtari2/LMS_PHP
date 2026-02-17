<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\LessonService;
use Illuminate\Http\Request;

class LessonApiController extends Controller {
    protected $lessonService;

    public function __construct(LessonService $lessonService){
        $this->lessonService = $lessonService;
    }

}
