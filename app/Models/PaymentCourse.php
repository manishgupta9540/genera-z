<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaymentCourse extends Model
{
    use HasFactory;

    protected $fillable = [
        'course_id',
        'payment_id',
        'price_option_id',
        'amount',
    ];


    public function course() {
        return $this->belongsTo(Course::class);
    }

    public function paymentCourse() {
        return $this->belongsTo(Course::class);
    }
    public function priceOption() {
        return $this->belongsTo(PriceOption::class);
    }

    public function payment() {
        return $this->belongsTo(Payment::class);
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


