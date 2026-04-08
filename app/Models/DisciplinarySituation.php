<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DisciplinarySituation extends Model
{
    protected $fillable = [
        'believer_id',
        'reason',
        'start_date',
        'end_date',
        'observations',
        'status',
    ];

    protected $dates = [
        'start_date',
        'end_date',
    ];

    public function believer()
    {
        return $this->belongsTo(Believer::class);
    }
}
