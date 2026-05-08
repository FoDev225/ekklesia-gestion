<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ServiceRoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $roles = [
            [
                'code' => 'preacher',
                'name' => 'Prédicateur',
            ],
            [
                'code' => 'president',
                'name' => 'Président',
            ],
            [
                'code' => 'worship',
                'name' => 'Louange et adoration',
            ],
            [
                'code' => 'announcements',
                'name' => 'Annonceur',
            ],
            [
                'code' => 'translator',
                'name' => 'Traducteur',
            ],
        ];

        foreach ($roles as $role) {
            \App\Models\ServiceRole::create($role);
        }
    }
}
