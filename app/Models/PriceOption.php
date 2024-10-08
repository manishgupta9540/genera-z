<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PriceOption extends Model
{
    use HasFactory;

    protected $fillable = [
        'course_id',
        'price',
        'duration',
        'details',
    ];

    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    public function price()
    {
        if ($this->course->one_time) {
            return $this->course->price  * $this->duration ;
        }
        return $this->price * $this->duration;
    }

    public function realPrice() {
        if ($this->course->one_time) {
            return $this->course->price;
        }
        return $this->price;
    }

    public function duration()
    {
        if ($this->course->one_time) {
            return $this->course->duration;
        }
        return $this->duration;
    }


}
