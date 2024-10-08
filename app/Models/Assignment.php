<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Assignment extends Model
{
    use HasFactory;

    protected $fillable = [
        'sub_module_id',
        'title',
        'description',
        'duration',
        'pass_score',
        'max_score',
        'status',
        'attempts',
        'created_by',
        'type'
    ];

    protected static function booted()
    {
        static::creating(function ($assignment) {
            if (is_null($assignment->status)) {
                $assignment->status = 1;
            }
        });
    }

    public function sub_module()
    {
        return $this->belongsTo(SubModule::class);
    }

    public function questions()
    {
        return $this->hasMany(Question::class);
    }
    public function questionsShort()
    {
        return $this->hasMany(Question::class)->where('type', 0);
    }
    public function questionsMcq()
    {
        return $this->hasMany(Question::class)->where('type', 1);
    }


    public function userAssignments()
    {
        return $this->hasMany(UserAssignment::class);
    }

}
