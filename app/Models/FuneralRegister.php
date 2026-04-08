<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FuneralRegister extends Model
{
    protected $table = 'funeral_registers';
    
    protected $fillable = [
        'believer_id',

        'parent_firstname',
        'parent_lastname',

        'death_date',
        'burial_place',
        'family_relationship',
        
        'cause_of_death',
        'funeral_date',
        'funeral_place',

        'loincloths_number',
        'amount_paid',

        'nbre_pagne',
        'cash_amount',
    ];

    public function believer()
    {
        return $this->belongsTo(Believer::class);
    }
}
