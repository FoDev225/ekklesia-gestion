<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Language extends Model
{
    protected $table = 'languages';

    protected $fillable = [
        'code',
        'name',
    ];

    public function believers()
    {
        return $this->belongsToMany(Believer::class, 'believer_languages')
            ->withPivot('spoken', 'written')
            ->withTimestamps();
    }
}
