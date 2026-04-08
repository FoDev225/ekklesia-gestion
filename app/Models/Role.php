<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Role extends Model
{
    protected $table = 'roles';

    protected $fillable = [
        'name',
        'slug',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->slug = Str::slug($model->name);
        });
    }

    protected static function booted()
    {
        static::creating(function ($model) {
            $slug = Str::slug($model->name);
            $count = static::where('slug', 'like', "{$slug}%")->count();

            $model->slug = $count ? "{$slug}-{$count}" : $slug;
        });

        static::updating(function ($model) {
            if ($model->isDirty('name')) {
                $model->slug = Str::slug($model->name);
            }
        });
    }
}
