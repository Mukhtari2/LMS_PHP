<?php

namespace App\Models;

use App\Traits\BaseAudit;
use Illuminate\Database\Eloquent\Model;

class Enrollment extends Model
{
    use BaseAudit;
    
    protected $fillable = [
        'user_id',
        'course_id',
        'enrolled_at'
    ];
}
