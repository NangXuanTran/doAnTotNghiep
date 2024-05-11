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

    protected $fillable = [
        'password',
        'name',
        'email',
        'phone_number',
        'role',
        'birthday',
        'image_url',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    /**
     * Relationships
     */

    // n student - n class
    public function classrooms()
    {
        return $this->belongsToMany(Classroom::class, 'classroom_students', 'student_id', 'classroom_id');
    }

    // 1 teacher - n class
    public function classes()
    {
        return $this->hasMany(Classroom::class, 'teacher_id', 'id');
    }

    public function isAdmin()
    {
        return $this->role == 1;
    }

    public function isTeacher()
    {
        return $this->role == 2;
    }
}
