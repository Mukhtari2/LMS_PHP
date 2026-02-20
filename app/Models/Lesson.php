<?php

namespace App\Models;

use App\Traits\BaseAudit;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Lesson extends Model{

    use HasFactory;
    use BaseAudit;

    protected $fillable = [
        'course_id',
        'title',
        'content_url',

    ];

    public function course(){
        return $this -> belongsTo(Course::class);
    }

    public function assignments(){
        return $this -> hasMany(Assignment::class);
    }

}
