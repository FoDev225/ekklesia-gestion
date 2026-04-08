<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use App\Models\Believer;

class BelieversExport implements FromQuery, WithHeadings, WithMapping
{
    protected $baptized;
    protected $discipline;
    protected $categoryId;
    public function __construct($baptized = null, $discipline = null, $categoryId = null)
    {
        $this->baptized = $baptized;
        $this->discipline = $discipline;
        $this->categoryId = $categoryId;
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function query()
    {
        $query = Believer::with('category')->orderBy('lastname');

        // Filtre par Baptême
        if ($this->baptized) {
            $query->where('baptized', $this->baptized);
        }

        // Filtre par Discipline
        if ($this->discipline === 'oui') {
            $query->whereHas('disciplinarySituations', fn ($q) =>
                $q->where('status', 'active')
            );
        }
        elseif ($this->discipline === 'non') {
            $query->whereDoesntHave('disciplinarySituations', fn ($q) =>
                $q->where('status', 'active')
            );
        }

        // Filtre par Catégorie
        if ($this->categoryId) {
            $query->where('category_id', $this->categoryId);
        }

        return $query;
    }

    public function headings(): array
    {
        return [
            'N°',
            'Matricule',
            'Nom',
            'Prénoms',
            'Civilité',
            'Situation matrimoniale',
            'Date de naissance',
            'Ville de naissance',
            'Baptisé',
            'Date baptème',
            'Sanction',
            'Diplome',
            'Profession',
            'Qualification',
            'Quartier',
            'Téléphone',
            'Catégorie',
            'Année d’arrivée',
            'Eglise d\'origine',
            'Connaissnce de l\'église',
            'Contacter en cas d\'urgence',
        ];
    }

    public function map($believer): array
    {
        static $i = 1;

        return [
            $i++,
            $believer->register_number,
            $believer->lastname,
            $believer->firstname,
            $believer->civility,
            $believer->marital_status,
            $believer->birth_date->format('d/m/Y'),
            $believer->city_of_birth,
            $believer->baptized,
            optional($believer->baptism_date)->format('d/m/Y'),
            $believer->disciplinarySituations()->where('status', 'active')->exists() ? 'Sous discipline' : '',
            $believer->diplome,
            $believer->profession,
            $believer->qualification,
            $believer->neighborhood,
            $believer->contact,
            optional($believer->category)->name,
            $believer->arrival_year,
            $believer->origin_church,
            $believer->church_relationship,
            $believer->person_to_contact,
        ];
    }
}
