<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CulteActeur extends Model
{
    protected $table = 'culte_acteurs';
    
    protected $fillable = [
        'culte_id',
        'believer_id',
        'culte_role_id',
        'statut',
    ];

    public function culte()
    {
        return $this->belongsTo(Culte::class);
    }

    public function believer()
    {
        return $this->belongsTo(Believer::class);
    }

    public function culteRole()
    {
        return $this->belongsTo(CulteRole::class);
    }
}
