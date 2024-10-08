<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserCourse extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'course_id',
        'price_option_id',
        'payment_id',
        'progress',
        'rating',
        'review',
        'completed',
        'expires_at',
        'canceled_at',
    ];

    protected $casts = [
        'expires_at' => 'datetime',
        'canceled_at' => 'datetime',
        'completed' => 'boolean',
        'rating' => 'integer',
        'progress' => 'integer',
    ];

    // Define relationships
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    public function payment()
    {
        return $this->belongsTo(Payment::class);
    }

}
