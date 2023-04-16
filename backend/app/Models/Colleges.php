<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Colleges extends Model
{
    use HasFactory;
    protected $primaryKey = 'id_college';

    protected $fillable = [
        'college_name',
        'logo',
    ];


}
