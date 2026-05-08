<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\ChurchInfo;
use App\Models\Language;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        //User::factory(10)->create();

        User::factory()->create([
            'name' => 'Toure Boribaga',
            'username' => 'boribaga.toure',
            'email' => 'test@example.com',
            'password' => Hash::make('password'),
        ]);

         User::factory()->create([
            'name' => 'Kone Nicodème',
            'username' => 'nicodeme.kone',
            'email' => 'admin@example.com',
            'password' => Hash::make('password'),
        ]);

        ChurchInfo::create([
            'organisation' => 'AEBECI',
            'organisation_name' => 'Association des Églises Baptistes Evangéliques de Côte d\'Ivoire',
            'district' => 'DISTRICT DU SUD',
            'church_name' => 'YOPOUGON NOUVEAU BUREAU',
            'authorization' => '1660/INT/AT/AG/1 du 24/10/68',

            'address' => '01 BP 11332 Abidjan 01',
            'pastor_phone_number' => '0555145527',
            'secretary_phone_number' => '0141899162',
            'church_email' => 'aebeciyop.nb@gmail.com',
            'pastor_email' => 'tourebe2006@yahoo.fr',
            'localisation' => 'Yopougon Nouveau Bureau derrière le Collège FRELEC',
        ]);

        Language::create(['code' => 'fr', 'name' => 'Français']);
        Language::create(['code' => 'en', 'name' => 'Anglais']);
        Language::create(['code' => 'pt', 'name' => 'Portugais']);
        Language::create(['code' => 'sfo', 'name' => 'Sénoufo']);
        Language::create(['code' => 'ble', 'name' => 'Baoulé']);
        Language::create(['code' => 'mke', 'name' => 'Malinké']);
        Language::create(['code' => 'bte', 'name' => 'Bété']);
        Language::create(['code' => 'yac', 'name' => 'Yacouba']);

        $this->call([
            CategorySeeder::class,
            BelieverTableSeeder::class,
            GroupSeeder::class,
            TeamSeeder::class,
            ServiceRoleSeeder::class,
        ]);
    }
}
