<?php

namespace App\Exports;

use App\Models\Group;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class GroupMembersExport implements FromCollection, WithHeadings, ShouldAutoSize, WithStyles
{
    protected Group $group;
    protected array $filters;

    public function __construct(Group $group, array $filters = [])
    {
        $this->group = $group;
        $this->filters = $filters;
    }

    public function collection()
    {
        $query = $this->group->believers()->withPivot('role', 'joined_at');

        // 🔍 FILTRE RECHERCHE
        if (!empty($this->filters['search'])) {
            $search = $this->filters['search'];
            $query->where(function ($q) use ($search) {
                $q->where('lastname', 'like', "%{$search}%")
                  ->orWhere('firstname', 'like', "%{$search}%");
            });
        }

        // 👤 FILTRE SEXE
        if (!empty($this->filters['gender'])) {
            $query->where('gender', $this->filters['gender']);
        }

        // 🎭 FILTRE ROLE
        if (!empty($this->filters['role'])) {
            $query->wherePivot('role', $this->filters['role']);
        }

        return $query->orderBy('lastname')->orderBy('firstname')->get()->map(function ($believer, $index) {
            return [
                'N°' => $index + 1,
                'Nom' => $believer->lastname,
                'Prénom(s)' => $believer->firstname,
                'Sexe' => $believer->gender,
                'Date de naissance' => $believer->birth_date
                    ? Carbon::parse($believer->birth_date)->format('d/m/Y')
                    : '',
                'Téléphone' => optional($believer->address)->phone_number ?? '',
                'WhatsApp' => optional($believer->address)->whatsapp_number ?? '',
                'Rôle dans le groupe' => $believer->pivot->role ?? '',
                'Date d’intégration' => $believer->pivot->joined_at
                    ? Carbon::parse($believer->pivot->joined_at)->format('d/m/Y')
                    : '',
            ];
        });
    }

    public function headings(): array
    {
        return [
            'N°',
            'Nom',
            'Prénom(s)',
            'Sexe',
            'Date de naissance',
            'Téléphone',
            'WhatsApp',
            'Rôle dans le groupe',
            'Date d’intégration',
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            // Ligne d'en-tête
            1 => [
                'font' => ['bold' => true, 'size' => 12],
            ],
        ];
    }
}