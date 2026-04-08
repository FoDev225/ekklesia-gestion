<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Group;

class GroupSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $groups = [
            // Groupes de louange
            ['name' => 'Groupe Musical', 'description' => 'Groupe principal des instrumentistes'],
            ['name' => 'DEXY', 'description' => 'Groupe de louange DEXY'],
            ['name' => 'Chorale EDEN', 'description' => 'Chorale EDEN'],
            ['name' => 'Chorale HOREB', 'description' => 'Chorale Horeb'],
            ['name' => 'Chorale Sainte Cohorte', 'description' => 'Chorale Sainte Cohorte'],

            // Autres groupes
            ['name' => 'Evangélisation', 'description' => 'Équipe d’évangélisation'],
            ['name' => 'AFEBECI', 'description' => 'Groupe des femmes'],
            ['name' => 'J-AEBECI', 'description' => 'Groupe des jeunes'],
            ['name' => 'Prière', 'description' => 'Ministère de prière'],
            ['name' => 'Cellule sociale', 'description' => 'Cellule d’action sociale'],
            ['name' => 'Ordre et Accueil', 'description' => 'Service d’ordre et d’accueil'],
            ['name' => 'Nettoyage', 'description' => 'Équipe de nettoyage'],
            ['name' => 'Organisation', 'description' => 'Équipe d’organisation des événements'],
        ];

        foreach ($groups as $group) {
            Group::firstOrCreate(
                ['name' => $group['name']],
                ['description' => $group['description']]
            );
        }
    }
}
