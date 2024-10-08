<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    use HasFactory;
    protected $fillable = [
        'title',
        'rating',
        'headline',
        'overview',
        'description',
        'summary',
        'category_id',
        'duration',
        'total_modules',
        'one_time',
        'price',
        'plan_info',
        'image'
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function modules()
    {
        return $this->hasMany(Module::class);
    }
    public function objectives()
    {
        return $this->hasMany(Objective::class);
    }
    public function priceOptions()
    {
        return $this->hasMany(PriceOption::class);
    }

    public function skills()
    {
        return $this->belongsToMany(Skill::class, 'course_skills');
    }

    public function userCourses()
    {
        return $this->hasMany(UserCourse::class);
    }

    public function course()
    {
        return $this->hasMany(PaymentCourse::class);
    }

    public function price()
    {
        if ($this->one_time) {
            return $this->price;
        }

        // Ensure that `priceOptions()` is returning different values based on context.
        $priceOption = $this->priceOptions()->first();
        return $priceOption ? $priceOption->price * $priceOption->duration : null;
    }

    public function realPrice()
    {
        if ($this->one_time) {
            return $this->price;
        }

        $priceOption = $this->priceOptions()->first();
        return $priceOption ? $priceOption->price : null;
    }

    public function duration()
    {
        if ($this->one_time) {
            return $this->duration;
        }

        $priceOption = $this->priceOptions()->first();
        return $priceOption ? $priceOption->duration : null;
    }

}
