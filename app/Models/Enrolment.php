<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Enrolment extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'student_id',
        'course_id',
        'class_id',
        'teacher_id',
        'plan_id',
        'required_amount',
        'total_paid_amount',
        'created_by',
        'updated_by',
        'deleted_by',
    ];
}
