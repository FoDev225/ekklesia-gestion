<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TeamActivityDocument extends Model
{
    protected $table = 'team_activity_documents';

    protected $fillable = [
        'team_id',
        'activity_program_id',
        'title',
        'file_path',
        'presence_list_file_path',
        'uploaded_by',
    ];

    public function activityProgram()
    {
        return $this->belongsTo(ActivityProgram::class, 'activity_program_id');
    }

    public function team()
    {
        return $this->belongsTo(Team::class, 'team_id');
    }
}
