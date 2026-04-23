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
            ['name' => 'DEXY', 'description' => 'Divine Espérance Xylophone de Yopougon'],
            ['name' => 'Chorale EDEN', 'description' => 'Chorale balafon EDEN'],
            ['name' => 'Chorale HOREB', 'description' => 'Chorale Horeb'],
            ['name' => 'Chorale Sainte Cohorte', 'description' => 'Chorale Sainte Cohorte'],
            ['name' => 'Ordre et Accueil', 'description' => 'Service d’ordre et d’accueil'],
            ['name' => 'Nettoyage', 'description' => 'Équipe de nettoyage'],
        ];

        foreach ($groups as $group) {
            Group::firstOrCreate(
                ['name' => $group['name']],
                ['description' => $group['description']]
            );
        }
    }
}
