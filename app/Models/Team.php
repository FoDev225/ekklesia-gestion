<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Team extends Model
{
    protected $table = 'teams';
    
    protected $fillable = [
        'name',
        'description',
        'objectif',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function believers()
    {
        return $this->belongsToMany(Believer::class, 'believer_team')
            ->withPivot('role', 'joined_at')
            ->withTimestamps();
    }

    public function activityPrograms()
    {
        return $this->hasMany(ActivityProgram::class);
    }

    public function objectives()
    {
        return $this->hasMany(TeamObjective::class);
    }

    public function activityExpenses()
    {
        return $this->hasMany(TeamActivityExpense::class);
    }

    public function activityDocuments()
    {
        return $this->hasMany(TeamActivityDocument::class);
    }

}
