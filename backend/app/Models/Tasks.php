<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tasks extends Model
{
    use HasFactory;

    protected $primaryKey = 'id_tasks';
    
    protected $fillable = [
        'id_category',
        'id_course_uf',
        'type',
        'title',
        'description',
        'file_rubrica',
        'contents',
        'limit_date',
        'percentage',
        'max_mark',
    ];
}
