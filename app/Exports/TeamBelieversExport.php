<?php

namespace App\Exports;

use App\Models\Team;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class TeamBelieversExport implements FromCollection, WithHeadings
{
    protected $team;
    protected $search;
    protected $gender;

    public function __construct(Team $team, $search = null, $gender = null)
    {
        $this->team = $team;
        $this->search = $search;
        $this->gender = $gender;
    }

    public function collection()
    {
        return $this->team->believers()
            ->when($this->search, function ($query) {
                $query->where(function ($q) {
                    $q->where('firstname', 'like', '%' . $this->search . '%')
                      ->orWhere('lastname', 'like', '%' . $this->search . '%');
                });
            })
            ->when($this->gender, function ($query) {
                $query->where('gender', $this->gender);
            })
            ->get()
            ->map(function ($believer) {
                return [
                    'Nom' => $believer->lastname,
                    'Prénom' => $believer->firstname,
                    'Sexe' => $believer->gender,
                    'Téléphone' => optional($believer->address)->phone_number,
                    'WhatsApp' => optional($believer->address)->whatsapp_number,
                    'Rôle dans l’équipe' => $believer->pivot->role,
                    'Date d’intégration' => $believer->pivot->joined_at,
                ];
            });
    }

    public function headings(): array
    {
        return [
            'Nom',
            'Prénom',
            'Sexe',
            'Téléphone',
            'WhatsApp',
            'Rôle dans l’équipe',
            'Date d’intégration',
        ];
    }
}