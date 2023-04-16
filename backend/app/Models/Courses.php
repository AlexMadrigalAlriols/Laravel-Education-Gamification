<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Courses extends Model
{
    use HasFactory;
    protected $primaryKey = 'id_course';

    protected $fillable = [
        'course_name',
        'id_teacher',
        'id_college',
        'shop',
        'img',
        'code',
    ];

}
