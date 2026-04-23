<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ActivityProgram extends Model
{
    protected $table = 'activity_programs';
    
    protected $fillable = [
        'team_id',

        'title',
        'theme',
        'moderator',
        'preacher',

        'scheduled_date',
        'month',
        'year',

        'location',
        'status',
    ];

    protected $casts = [
        'scheduled_date' => 'date',
    ];

    public function team()
    {
        return $this->belongsTo(Team::class);
    }

    public function expenses()
    {
        return $this->hasMany(TeamActivityExpense::class, 'activity_program_id');
    }

    public function documents()
    {
        return $this->hasMany(TeamActivityDocument::class, 'activity_program_id');
    }
}
