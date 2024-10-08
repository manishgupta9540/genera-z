<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id',
        'user_id',
        'tracking_id',
        'bank_ref_no',
        'amount',
        'success',
        'success_at',
        'order_status',
    ];

    public function paymentCourses()
    {
        return $this->hasMany(PaymentCourse::class);
    }
    public function student()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
