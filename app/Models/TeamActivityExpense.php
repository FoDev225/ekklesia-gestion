<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TeamActivityExpense extends Model
{
    protected $fillable = [
        'team_id',
        'activity_program_id',
        'label',
        'amount',
        'expense_date',
    ];

    protected $casts = [
        'expense_date' => 'date',
        'amount' => 'decimal:2',
    ];

    public function team()
    {
        return $this->belongsTo(Team::class);
    }

    public function activityProgram()
    {
        return $this->belongsTo(ActivityProgram::class);
    }
}
