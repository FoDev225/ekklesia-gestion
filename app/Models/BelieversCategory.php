<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class BelieversCategory extends Model
{
    protected $table = 'believers_categories';

    protected $fillable = [
        'name',
        'min_age',
        'max_age',
    ];

    // Define relationship with Believer model
    public function believers()
    {
        return $this->hasMany(Believer::class, 'category_id');
    }

     /**
     * Trouver la catégorie correspondant à un âge donné
     */
    public static function findByAge(int $age)
    {
        return self::where('min_age', '<=', $age)
            ->where(function (Builder $query) use ($age) {
                $query->where('max_age', '>=', $age)
                      ->orWhereNull('max_age'); // Adultes
            })
            ->orderBy('min_age')
            ->first();
    }
}
