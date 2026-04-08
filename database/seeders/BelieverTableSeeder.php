<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Believer;

class BelieverTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Believer::factory()->count(100)->create()->each(function ($believer) {
            // You can add additional logic here if needed for each created believer
            $believer->register_number = Believer::generateRegisterNumber($believer->id);
            $believer->saveQuietly(); // Pour éviter de déclencher des événements lors de la sauvegarde
        });
    }
}
