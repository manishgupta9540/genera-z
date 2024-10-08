<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'phone_number',
        'password',
        'role_id'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];



    public function courses()
    {
        return $this->hasManyThrough(
            Course::class,
            UserCourse::class,
            'user_id',
            'id',
            'id',
            'course_id',
        )->where('user_courses.completed', '1');
    }


    public function user_role()
    {
        return $this->belongsTo(User::class, 'role_id', 'id');
    }

    public function country()
    {
        return $this->belongsTo(Countrie::class, 'country_id', 'id');
    }

    public function carts()
    {
        return $this->hasMany(Cart::class);
    }

    public function userCourses()
    {
        return $this->hasMany(UserCourse::class);
    }

    public function userModules()
    {
        return $this->hasMany(UserModule::class);
    }

    public function userSubModules()
    {
        return $this->hasMany(UserSubModule::class);
    }

    public function userMaterials()
    {
        return $this->hasMany(UserMaterial::class);
    }

    public function userAssignments()
    {
        return $this->hasMany(UserAssignment::class);
    }


}
