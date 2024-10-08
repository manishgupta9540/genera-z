<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Material extends Model
{
    use HasFactory;
    protected $fillable = ['sub_module_id','name','content','reading','duration','ppt'];
    public function module()
    {
        return $this->belongsTo(Module::class,'module_id','id');
    }
    protected static function booted()
    {
        static::creating(function ($material) {
            if (is_null($material->status)) {
                $material->status = 1;
            }
        });
    }
    public function sub_module()
    {
        return $this->belongsTo(SubModule::class,'sub_module_id','id');
    }

    public function userMaterials()
    {
        return $this->hasMany(UserMaterial::class);
    }
}
