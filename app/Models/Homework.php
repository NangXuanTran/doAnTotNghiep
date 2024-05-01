<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Homework extends Model
{
    use HasFactory;

    protected $table = 'homeworks';

    protected $fillable = [
        'classroom_id',
        'homework_name',
        'time',
        'end_time',
    ];

    public function classroom()
    {
        return $this->belongsTo(Classroom::class, 'classroom_id', 'id');
    }

    public function questions()
    {
        return $this->hasMany(Question::class, 'homework_id', 'id');
    }
}
