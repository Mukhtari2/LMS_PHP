<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Submission extends Model{

    use HasFactory;

    protected $fillable = [
    'assignment_id',
    'user_id',
    'student_id',
    'file_url',
    'answered_at',
    'grade',
    'teacher_feedback',
    'submitted_at'
    ];

    public function student() {
         return $this->belongsTo(User::class, 'user_id');
    }

}
