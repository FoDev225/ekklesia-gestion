<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ChurchInfo extends Model
{
    use HasFactory;
    
    protected $table = 'church_infos';

    protected $fillable = [
        'organisation',
        'organisation_name',
        'district',
        'church_name',
        'authorization',

        'address',
        'pastor_phone_number',
        'secretary_phone_number',
        'church_email',
        'pastor_email',
        'localisation',

        'photo_path',
    ];
}
