<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Responsibility extends Model
{
    protected $table = 'responsibilities';

    protected $fillable = [
        'believer_id',
        'old',
        'current',
        'desired'
    ];

    public function believer()
    {
        return $this->belongsTo(Believer::class);
    }
}
