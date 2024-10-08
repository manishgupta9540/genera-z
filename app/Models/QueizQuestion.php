<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QueizQuestion extends Model
{
    use HasFactory;

    protected $fillable = ['assign_id','question_type', 'question','option','answer'];

    public function assignment()
    {
        return $this->belongsTo(Assignment::class,'assign_id','id');
    }
}
