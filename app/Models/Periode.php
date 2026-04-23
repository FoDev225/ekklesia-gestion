<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Periode extends Model
{
    protected $table = 'periodes';

    protected $fillable = [
        'name',
        'general_theme',
        'start_date',
        'end_date',
        'is_active',
        'is_archived',
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
        'is_active' => 'boolean',
        'is_archived' => 'boolean',
    ];

    public function services()
    {
        return $this->hasMany(Services::class);
    }

    public function scopeActivate($query)
    {
        return $query->where('is_active', true);
    }
}
