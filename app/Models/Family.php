<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Family extends Model
{
    protected $table = 'families';

    protected $fillable = [
        'family_name',
        'address',
        'phone_number',
        'notes',
    ];

    public function believers()
    {
        return $this->hasMany(Believer::class);
    }
}
