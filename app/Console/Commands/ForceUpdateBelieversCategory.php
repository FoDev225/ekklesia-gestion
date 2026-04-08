<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class ForceUpdateBelieversCategory extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'believers:force-update-category';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Force la mise à jour globale des catégories des fidèles via SQL';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $affected = DB::statement("
            UPDATE believers b
            JOIN believers_categories c
              ON TIMESTAMPDIFF(YEAR, b.birth_date, CURDATE())
                 BETWEEN c.min_age AND IFNULL(c.max_age, 200)
            SET b.category_id = c.id
            WHERE b.birth_date IS NOT NULL
        ");

        $this->info('Mise à jour globale terminée avec succès.');

        return Command::SUCCESS;
    }
}
