<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ServiceRole extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        ServiceRole::insert([
        ['name' => 'Prédicateur', 'code' => 'preacher'],
        ['name' => 'Suppléant prédicateur', 'code' => 'preacher_backup'],
        ['name' => 'Présidence', 'code' => 'president'],
        ['name' => 'Suppléant présidence', 'code' => 'president_backup'],
        ['name' => 'Louange', 'code' => 'worship'],
        ['name' => 'Annonces', 'code' => 'announcements'],
    ]);
    }
}
