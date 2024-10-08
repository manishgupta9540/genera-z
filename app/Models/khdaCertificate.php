<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class khdaCertificate extends Model
{
    use HasFactory;
    protected $table = 'khda_certificates';
    protected $fillable = [
        'student_id',
        'name_in_arabic',
        'name_in_english',
        'religion',
        'gender',
        'dob',
        'email',
        'nationality',
        'passport_number',
        'amount',
        'order_id',
        'passport_image',
    ];
}
