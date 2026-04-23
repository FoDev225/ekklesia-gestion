<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TeamObjective extends Model
{
    protected $table = 'team_objectives';

    protected $fillable = [
        'team_id',
        'year',
        'main_goal',
        'budget_forecast',
        'kpis',
        'target_activities',
    ];

    public function team()
    {
        return $this->belongsTo(Team::class);
    }
}
