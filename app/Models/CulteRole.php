<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CulteRole extends Model
{
    protected $table = 'culte_roles';
    
    protected $fillable = ['code', 'description'];

    public function cultes()
    {
        return $this->belongsToMany(Culte::class, 'culte_acteurs')
            ->withPivot(['believer_id', 'statut'])
            ->withTimestamps();
    }
}
