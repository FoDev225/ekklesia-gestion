<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BelieverTeam extends Model
{
    protected $table = 'believer_team';

    protected $fillable = [
        'believer_id',
        'team_id',
        'role',
        'joined_at',
    ];

    public function believer()
    {
        return $this->belongsTo(Believer::class);
    }

    public function team()
    {
        return $this->belongsTo(Team::class);
    }
}
