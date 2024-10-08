<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Module extends Model
{
    use HasFactory;

    protected $fillable = ['course_id','name','status'];

    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    public function sub_modules()
    {
        return $this->hasMany(SubModule::class);
    }

    public function userModules()
    {
        return $this->hasMany(UserModule::class);
    }
}
