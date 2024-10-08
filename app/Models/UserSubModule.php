<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserSubModule extends Model
{
    use HasFactory;

    protected $fillable = ['sub_module_id', 'user_id', 'progress', 'completed'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function subModule()
    {
        return $this->belongsTo(SubModule::class);
    }
}

