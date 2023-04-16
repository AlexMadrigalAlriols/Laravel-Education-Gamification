<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Course_uf extends Model
{
    use HasFactory;

    protected $primaryKey = 'id_course_uf';

    protected $table = 'course_uf';

    protected $fillable = [
        'name',
        'total_points',
    ];
}
