<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Education extends Model
{
    protected $table = 'education';
    
    protected $fillable = [
        'believer_id',
        'level_of_education',
        'degree',
        'qualification',
    ];

    public function believer()
    {
        return $this->belongsTo(Believer::class);
    }
}
