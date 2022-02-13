<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Agenda extends Model
{
    use HasFactory;

    protected $fillable = [
        'class_id',
        'course_id',
        'day',
        'from',
        'to',
        'color',
        'created_by',
        'updated_by',
        'deleted_by',
    ];
}
