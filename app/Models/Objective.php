<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Objective extends Model
{
    use HasFactory;

    protected $fillable = ['content', 'course_id'];

    public function course()
    {
        $this->belongsTo(Course::class);
    }
}
