<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\Team;

class TeamSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $teams = [
            [
                'name' => 'AFEBECI',
                'description' => 'Équipe des femmes',
                'objectif' => 'Encadrement, édification et activités des femmes',
            ],
            [
                'name' => 'J-AEBECI',
                'description' => 'Équipe des jeunes',
                'objectif' => 'Encadrement, édification et activités des jeunes',
            ],
            [
                'name' => 'Prière',
                'description' => 'Équipe de prière',
                'objectif' => 'Intercession et couverture spirituelle de la communauté',
            ],
            [
                'name' => 'Évangélisation',
                'description' => 'Équipe d’évangélisation',
                'objectif' => 'Organisation des campagnes et sorties d’évangélisation',
            ],
        ];

        foreach ($teams as $team) {
            Team::updateOrCreate(
                ['name' => $team['name']],
                $team
            );
        }
    }
}
