<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Pivot;

class CourseSkill extends Pivot
{
    use HasFactory;
    protected $table = 'course_skills';
    protected $fillable = [
        'course_id',
        'skill_id',
    ];
}
