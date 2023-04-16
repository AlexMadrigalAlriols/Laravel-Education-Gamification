<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Popers extends Model
{
    use HasFactory;

    protected $primaryKey = 'id_poper';

    protected $fillable = [
        'poper_name',
        'skin',
        'level',
        'current_exp',
        'stats',
        'stats_base',
        'abilities',
        'element',
    ];

}
