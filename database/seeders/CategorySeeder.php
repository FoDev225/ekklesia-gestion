<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\BelieversCategory;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            ['name' => 'Nourrisson', 'min_age' => 0, 'max_age' => 2],
            ['name' => 'Pré-scolaire', 'min_age' => 3, 'max_age' => 4],
            ['name' => 'ECODIM', 'min_age' => 5, 'max_age' => 18],
            ['name' => 'Jeune', 'min_age' => 19, 'max_age' => 40],
            ['name' => 'Adulte', 'min_age' => 41, 'max_age' => null],
        ];

        foreach ($categories as $category) {
            BelieversCategory::create($category);
        }
    }
}
