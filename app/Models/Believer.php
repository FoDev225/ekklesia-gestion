<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;
use Carbon\Carbon;
use App\Models\BelieversCategory;

use App\Models\Scopes\ActiveBelieverScope;

class Believer extends Model
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;
    protected $table = 'believers';

    protected $fillable = [
        'register_number',
        'lastname',
        'firstname',
        'gender',

        'marital_status',
        'spouse_name',
        'marriage_date',

        'birth_date',
        'birth_place',
        'ethnicity',
        'nationality',
        'number_of_children',
        
        'cni_number',

        'family_id',
        'category_id',

        'is_active',
        'left_at',
        'deceased_at',
    ];

    protected $casts = [
        'birth_date' => 'date',
        'left_at' => 'date',
        'deceased_at' => 'date',
        'marriage_date' => 'date',
    ];

    // Gender : Féminin / Masculin
    public static function genders()
    {
        return ['Féminin', 'Masculin'];
    }

    // Situation matrimoniale : Célibataire / Marié(e) / Veuf(ve) / Divorcé(e)
    public static function maritalStatus()
    {
        return ['Célibataire', 'Marié(e)', 'Divorcé(e)', 'Veuf(ve)'];
    }

    // Generate Register Number
    public static function generateRegisterNumber(int $id): string
    {
        $year = now()->format('y'); // On récupere les deux derniers chiffres de l'année en cours
        $prefix = 'YOPNB';
        // Utilise l'ID réel
        $nextNumber = str_pad($id, 4, '0', STR_PAD_LEFT);
        // Deux lettres majuscules aléatoires 
        $rundomLetters = Str::upper(Str::random(2));

        // Composition finale du numéro d'enregistrement
        return "{$year}-{$prefix}{$nextNumber}{$rundomLetters}";
    }

    // Relationship with category
    public function category()
    {
        return $this->belongsTo(BelieversCategory::class, 'category_id');
    }

    // Relationship with funeral registers
    public function funeralRegisters()
    {  
        return $this->hasMany(FuneralRegister::class, 'believer_id');
    }

    // Relationship with disciplinary situations
    public function disciplinarySituations()
    {
        return $this->hasMany(DisciplinarySituation::class, 'believer_id');
    }

    // Relation with user
    public function user()
    {
        return $this->hasOne(User::class, 'believer_id');
    }

    public function getAgeAttribute()
    {
        return $this->birth_date ?
            Carbon::parse($this->birth_date)->age
            : null;
    }

    // Child Dedications where this believer is father
    public function childDedicationsAsFather()
    {
        return $this->hasMany(ChildDedication::class, 'father_id');
    }
    // Child Dedications where this believer is mother
    public function childDedicationsAsMother()
    {
        return $this->hasMany(ChildDedication::class, 'mother_id');
    }

    public function scopeSearch($query, $term)
    {
        $term = '%' . $term . '%';

        return $query->where(function ($q) use ($term) {
            $q->where('lastname', 'like', $term)
            ->orWhere('firstname', 'like', $term)
            ->orWhere('contact', 'like', $term)
            ->orWhere('email', 'like', $term);
        });
    }

    // Relationship with mariage registers as groom
    public function mariageRegistersAsGroom()
    {
        return $this->hasMany(MariageRegister::class, 'groom_id');
    }
    // Relationship with mariage registers as bride
    public function mariageRegistersAsBride()
    {
        return $this->hasMany(MariageRegister::class, 'bride_id');
    }


    // Relationship with believer departures
    public function departures()
    {
        return $this->hasMany(BelieverDeparture::class, 'believer_id');
    }

    public function hasLeft(): bool
    {
        return !is_null($this->left_at);
    }

    public function isDeceased(): bool
    {
        return !is_null($this->deceased_at);
    }

    public function canBeReintegrated(): bool
    {
        return $this->hasLeft() && !$this->isDeceased();
    }

    protected static function booted()
    {
        static::addGlobalScope(new ActiveBelieverScope);
    }

    public function cultes()
    {
        return $this->belongsToMany(Culte::class, 'culte_acteurs')
            ->withPivot(['culte_role_id', 'statut'])
            ->withTimestamps();
    }

    public function languages()
    {
        return $this->belongsToMany(Language::class, 'believer_languages')
            ->withPivot('spoken', 'written')
            ->withTimestamps();
    }

    public function groups()
    {
        return $this->belongsToMany(Group::class, 'believer_groups')
            ->withPivot('role', 'joined_at')
            ->withTimestamps();
    }

    public function departments()
    {
        return $this->belongsToMany(Department::class, 'believer_departments')
            ->withTimestamps();
    }

    public function churchInformation()
    {
        return $this->hasOne(ChurchInformation::class);
    }

    public function address()
    {
        return $this->hasOne(Adress::class);
    }

    public function education()
    {
        return $this->hasOne(Education::class);
    }

    public function profession()
    {
        return $this->hasOne(Profession::class);
    }

    public function responsibility()
    {
        return $this->hasOne(Responsibility::class);
    }

    public function family()
    {
        return $this->belongsTo(Family::class);
    }
}
