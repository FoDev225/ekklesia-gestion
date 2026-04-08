<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ChildDedication extends Model
{
    protected $table = 'child_dedications';

    protected $fillable = [
        'father_id',
        'mother_id',
        'father_name',
        'mother_name',
        'demande_date',
        'dedication_date',
        'child_lastname',
        'child_firstname',
        'gender',
        'child_birthdate',
        'child_birthplace',
    ];

    protected $casts = [
        'demande_date' => 'date',
        'dedication_date' => 'date',
        'child_birthdate' => 'date',
    ];

    public static function child_gender()
    {
        return ['Féminin', 'Masculin'];
    }

    public function father()
    {
        return $this->belongsTo(Believer::class, 'father_id');
    }
    public function mother()
    {
        return $this->belongsTo(Believer::class, 'mother_id');
    }
}
