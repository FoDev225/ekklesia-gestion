<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Believer;
use App\Models\BelieversCategory;

class UpdateBelieversCategory extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'believers:update-category';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Met à jour la catégorie des fidèles selon leur âge';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        Believer::whereNotNull('birth_date')
            ->chunk(100, function ($believers) {
                foreach ($believers as $believer) {
                    $age = $believer->age;

                    if ($age === null) {
                        continue;
                    }

                    $category = BelieversCategory::findByAge($age);

                    if ($category && $believer->category_id != $category->id) {
                        $believer->updateQuietly([
                            'category_id' => $category->id,
                        ]);
                    }
                }
            });

        $this->info('Catégories mises à jour');
    }
}
