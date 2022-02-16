<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Student extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'lname',
        'fname',
        'birthdate',
        'address',
        'sex',
        'level_id',
        'father',
        'mother',
        'email',
        'phone1',
        'phone2',
        'notes',
        'created_by',
        'updated_by',
        'deleted_by',
    ];

    public function level()
    {
        return $this->belongsTo(Level::class, 'level_id', 'id');
    }

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by', 'id')->withTrashed();
    }

    public function updatedBy()
    {
        return $this->belongsTo(User::class, 'updated_by', 'id')->withTrashed();
    }

    public function deletedBy()
    {
        return $this->belongsTo(User::class, 'deleted_by', 'id')->withTrashed();
    }

    public function enrolments()
    {
        return $this->hasMany(Enrolment::class, 'student_id', 'id');
    }

    public function courses()
    {
        return $this->hasManyThrough(Course::class, Enrolment::class,'student_id', 'enrolment_id');
    }
}
