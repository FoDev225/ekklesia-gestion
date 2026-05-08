<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ServiceAssignment extends Model
{
    protected $table = 'service_assignments';

    protected $fillable = [
        'service_id',
        'service_role_id',
        'believer_id',
        'group_id',
        'is_backup',
    ];

    public function service()
    {
        return $this->belongsTo(Service::class);
    }

    public function role()
    {
        return $this->belongsTo(ServiceRole::class, 'service_role_id');
    }

    public function believer()
    {
        return $this->belongsTo(Believer::class, 'believer_id');
    }

    public function group()
    {
        return $this->belongsTo(Group::class, 'group_id');
    }
}
