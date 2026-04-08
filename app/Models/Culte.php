<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Culte extends Model
{
    protected $table = 'cultes';
    
    protected $fillable = [
        'periode_id',
        'culte_date',
        'culte_theme',
        'biblical_text',
        'culte_type',
    ];

    public function periode()
    {
        return $this->belongsTo(Periode::class);
    }

    public function acteurs()
    {
        return $this->hasMany(CulteActeur::class);
    }

    public function roles()
    {
        return $this->belongsToMany(CulteRole::class, 'culte_acteurs')
            ->withPivot(['believer_id', 'statut'])
            ->withTimestamps();
    }

}
