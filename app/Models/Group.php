<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    protected $table = 'groups';
    
    protected $fillable = [
        'name',
        'description',
    ];

    public function believers()
    {
        return $this->belongsToMany(Believer::class, 'believer_groups')
                    ->withPivot('role', 'joined_at')
                    ->withTimestamps();
    }

    public function getMembersCountAttribute()
    {
        return $this->believers()->count();
    }
}
