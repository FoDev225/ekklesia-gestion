<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BelieverDepartment extends Model
{
    protected $table = 'believer_departments';
    
    protected $fillable = [
        'believer_id',
        'department_id',
        'role',
        'joined_at'
    ];

    public function believer()
    {
        return $this->belongsTo(Believer::class);
    }

    public function department()
    {
        return $this->belongsTo(Department::class);
    }
}
