<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BelieverDeparture extends Model
{
    protected $table = 'believer_departures';

    protected $fillable = [
        'believer_id',
        'type',
        'reason',
        'comment',
        'departure_date',
    ];

    // Define relationships with Believer model if necessary
    public function believer()
    {
        return $this->belongsTo(Believer::class)->withoutGlobalScopes();
    }
}
