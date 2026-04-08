<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Profession extends Model
{
    protected $table = 'professions';
    
    protected $fillable = [
        'believer_id',
        'profession',
        'fonction',
        'company',
        'professional_contact',
    ];

    public function believer()
    {
        return $this->belongsTo(Believer::class);
    }
}
