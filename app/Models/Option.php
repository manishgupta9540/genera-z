<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Option extends Model
{
    use HasFactory;

    protected $fillable = [
        'assignment_id',
        'content',
        'question_id',
    ];


    public function assignment()
    {
        return $this->belongsTo(Assignment::class);
    }

    public function question()
    {
        return $this->belongsTo(Question::class);
    }
}
