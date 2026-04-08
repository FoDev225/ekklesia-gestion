<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BelieverLanguage extends Model
{
    protected $table = 'believer_languages';

    protected $fillable = [
        'believer_id',
        'language_id',
        'spoken',
        'written',
    ];

    public function believer()
    {
        return $this->belongsTo(Believer::class);
    }

    public function language()
    {
        return $this->belongsTo(Language::class);
    }
}
