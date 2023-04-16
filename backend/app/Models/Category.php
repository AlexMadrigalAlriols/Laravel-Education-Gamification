<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $primaryKey = 'id_category';
    protected $table = 'category';

    protected $fillable = [
        'id_course',
        'title',
        'order',
        
    ];
}
