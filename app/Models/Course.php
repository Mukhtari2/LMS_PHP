<?php

namespace App\Models;

use App\Traits\BaseAudit;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Course extends Model {
    use HasFactory;
    use BaseAudit;
    
    protected $fillable = [
        'title',
        'description',
        'teacher_id',
        'is_published'
    ];

    public function teacher(): BelongsTo{
        return $this -> belongsTo(User:: class, 'teacher_id');
    }

    public function lessons() {
        return $this -> hasMany(Lesson::class);
    }

}
