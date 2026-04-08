<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Periode extends Model
{
    protected $table = 'periodes';
    
    protected $fillable = [
        'name',
        'general_theme',
        'start_date',
        'end_date',
    ];
}
