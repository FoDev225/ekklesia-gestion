<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BelieverGroup extends Model
{
    protected $table = 'believer_groups';
    
    protected $fillable = [
        'believer_id',
        'group_id',
        'role',
        'joined_at',
    ];

    public function believer()
    {
        return $this->belongsTo(Believer::class, 'believer_id');
    }

    public function group()
    {
        return $this->belongsTo(Group::class, 'group_id');
    }
}
