<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Adress extends Model
{
    protected $table = 'adresses';

    protected $fillable = [
        'believer_id',
        'whatsapp_number',
        'phone_number',
        'email',
        'commune',
        'quartier',
        'sous_quartier',
    ];

    public function believer()
    {
        return $this->belongsTo(Believer::class);
    }
}
