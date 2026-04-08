<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    protected $table = 'events';
    
    protected $fillable = [
        'title',
        'description',
        'event_date',
        'location',
        'attendance',
        'attendance_list',
    ];
}
