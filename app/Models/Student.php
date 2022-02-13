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
        'birthplace',
        'sex',
        'level-id',
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
}
