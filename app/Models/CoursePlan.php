<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CoursePlan extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'course_id',
        'plan_id',
        'price',
        'created_by',
        'updated_by',
        'deleted_by',
    ];
}
