<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    use HasFactory;
    protected $fillable = [
        'course_id',
        'user_id',
        'price_option_id'
    ];

    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function priceOption()
    {
        return $this->belongsTo(PriceOption::class);
    }
    public function price()
    {
        if ($this->course->one_time) {
            return $this->course->price;
        }
        return $this->priceOption->price * $this->priceOption->duration;
    }
    
    public function realPrice() {
        if ($this->course->one_time) {
            return $this->course->price;
        }
        return $this->priceOption->price;
    }

    public function duration()
    {
        if ($this->course->one_time) {
            return $this->course->duration;
        }
        return $this->priceOption->duration;
    }
}
