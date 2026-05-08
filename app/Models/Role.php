<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Role extends Model
{
    protected $table = 'roles';

    protected $fillable = [
        'name',
        'code',
    ];

    public function users()
    {
        return $this->belongsToMany(User::class, 'role_user');
    }

    // protected static function boot()
    // {
    //     parent::boot();

    //     static::creating(function ($model) {
    //         $model->code = Str::slug($model->name);
    //     });
    // }

    // protected static function booted()
    // {
    //     static::creating(function ($model) {
    //         $slug = Str::slug($model->name);
    //         $count = static::where('code', 'like', "{$slug}%")->count();

    //         $model->code = $count ? "{$slug}-{$count}" : $slug;
    //     });

    //     static::updating(function ($model) {
    //         if ($model->isDirty('name')) {
    //             $model->code = Str::slug($model->name);
    //         }
    //     });
    // }
}
