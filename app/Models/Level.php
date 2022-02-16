<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Level extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
    ];

    public function courses()
    {
        return $this->hasMany(CourseLevel::class, 'level_id', 'id');
    }

    public function students()
    {
        return $this->hasMany(Student::class, 'level_id', 'id');
    }
}
