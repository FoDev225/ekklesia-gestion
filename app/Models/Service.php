<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    protected $table = 'services';

    protected $fillable = [
        'periode_id',
        'service_date',
        'service_theme',
        'service_type',
        'description',
    ];

    protected $casts = [
        'service_date' => 'date',
    ];

    public function periode()
    {
        return $this->belongsTo(Periode::class);
    }

    public function roles()
    {
        return $this->belongsToMany(ServiceRole::class, 'service_assignments')
            ->withPivot(['believer_id', 'group_id', 'is_backup'])
            ->withTimestamps();
    }

    public function assignments()
    {
        return $this->hasMany(\App\Models\ServiceAssignment::class);
    }

    public function getAssignmentsByRole($code)
    {
        return $this->assignments
            ->where('role.code', $code);
    }

    protected static function booted()
    {
        static::creating(function ($service) {
            if (!$service->periode_id) {
                $periode = \App\Models\Periode::where('is_active', true)->first();

                if ($periode) {
                    $service->periode_id = $periode->id;
                }
            }
        });
    }
}
