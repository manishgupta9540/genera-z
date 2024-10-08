<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubModule extends Model
{
    use HasFactory;


    protected $fillable = ['module_id','name'];

    public function module()
    {
        return $this->belongsTo(Module::class);
    }

    public function assement()
    {
        return $this->belongsTo(Assement::class);
    }

    public function materials()
    {
        return $this->hasMany(Material::class);
    }

    public function assignmentShort()
    {
        return $this->hasMany(Assignment::class)->where('type',0);
    }
    public function assignmentMcq()
    {
        return $this->hasMany(Assignment::class)->where('type',1);
    }
    public function assignments()
    {
        return $this->hasMany(Assignment::class);
    }

    public function userSubModules()
    {
        return $this->hasMany(UserSubModule::class);
    }

}
