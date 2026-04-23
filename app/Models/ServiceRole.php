<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ServiceRole extends Model
{
    protected $table = 'service_roles';
    
    protected $fillable = ['code', 'name'];

    public function assignments()
    {
        return $this->hasMany(ServiceAssignment::class);
    }
}
