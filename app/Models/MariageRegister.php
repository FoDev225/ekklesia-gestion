<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MariageRegister extends Model
{
    protected $table = 'mariage_registers';

    protected $fillable = [
        'groom_id',
        'groom_name',
        'groom_birthdate',
        'groom_birth_place',
        'groom_bapistism_date',
        'groom_bapistism_place',
        'baptism_officer_groom',
        'groom_profession',
        'groom_photo',

        'bride_id',
        'bride_name',
        'bride_birthdate',
        'bride_birth_place',
        'bride_bapistism_date',
        'bride_bapistism_place',
        'baptism_officer_bride',
        'bride_profession',
        'bride_photo',

        'civil_marriage_date',
        'civil_marriage_place',

        'religious_marriage_date',
        'religious_marriage_place',
        'wedding_mc',
        'wedding_preacher',
        'hand_bible',
        'officiant',

        'groom_witness',
        'groom_witness_profession',

        'bride_witness',
        'bride_witness_profession',
    ];

    protected $casts = [
        'groom_birthdate' => 'date',
        'groom_bapistism_date' => 'date',
        'bride_birthdate' => 'date',
        'bride_bapistism_date' => 'date',
        'civil_marriage_date' => 'date',
        'religious_marriage_date' => 'date',
    ];

    // Relationships
    public function groom()
    {
        return $this->belongsTo(Believer::class, 'groom_id');
    }

    public function bride()
    {
        return $this->belongsTo(Believer::class, 'bride_id');
    }
}
