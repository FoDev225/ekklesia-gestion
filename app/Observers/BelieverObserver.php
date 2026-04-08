<?php

namespace App\Observers;

use App\Models\Believer;
use App\Models\BelieversCategory;
use Carbon\Carbon;

class BelieverObserver
{
    /**
     * Avant création
     */
    public function creating(Believer $believer): void
    {
        $this->assignCategory($believer);
    }

    /**
     * Avant mise à jour
     */
    public function updating(Believer $believer): void
    {
        if ($believer->isDirty('birth_date')) {
            $this->assignCategory($believer);
        }
    }

    /**
     * Après création (ID disponible)
     */
    public function created(Believer $believer): void
    {
        if (!$believer->register_number) {
            $believer->updateQuietly([
                'register_number' => Believer::generateRegisterNumber($believer->id),
            ]);
        }
    }

    /**
     * Logique centrale
     */
    protected function assignCategory(Believer $believer): void
    {
        if (!$believer->birth_date) {
            return;
        }

        $age = Carbon::parse($believer->birth_date)->age;
        $category = BelieversCategory::findByAge($age);

        $believer->category_id = $category?->id;
    }
}
