<?php

namespace App\Services;

use App\Models\Believer;
use Illuminate\Support\Facades\DB;

class BelieverService
{
    /**
     * Création complète d’un fidèle
     */
    public function create(array $data): Believer
    {
        return DB::transaction(function () use ($data) {
            $believer = Believer::create($this->extractBelieverData($data));

            $this->handleOneToOneRelations($believer, $data);
            $this->handleManyToManyRelations($believer, $data);

            return $believer;
        });
    }

    /**
     * Mise à jour complète d’un fidèle
     */
    public function update(Believer $believer, array $data): Believer
    {
        return DB::transaction(function () use ($believer, $data) {
            $believer->update($this->extractBelieverData($data));

            $this->handleOneToOneRelations($believer, $data);
            $this->handleManyToManyRelations($believer, $data);

            return $believer;
        });
    }

    /**
     * Champs de la table believers uniquement
     */
    private function extractBelieverData(array $data): array
    {
        return [
            'lastname' => $data['lastname'] ?? null,
            'firstname' => $data['firstname'] ?? null,
            'gender' => $data['gender'] ?? null,
            'marital_status' => $data['marital_status'] ?? null,
            'marriage_date' => $data['marriage_date'] ?? null,
            'spouse_name' => $data['spouse_name'] ?? null,
            'birth_date' => $data['birth_date'] ?? null,
            'birth_place' => $data['birth_place'] ?? null,
            'ethnicity' => $data['ethnicity'] ?? null,
            'nationality' => $data['nationality'] ?? null,
            'number_of_children' => $data['number_of_children'] ?? null,
            'cni_number' => $data['cni_number'] ?? null,
        ];
    }

    /**
     * Relations One-to-One
     */
    private function handleOneToOneRelations(Believer $believer, array $data): void
    {
        if (!empty($data['address'])) {
            $believer->address()->updateOrCreate(
                ['believer_id' => $believer->id],
                $data['address']
            );
        }

        if (!empty($data['church_information'])) {
            $believer->churchInformation()->updateOrCreate(
                ['believer_id' => $believer->id],
                $data['church_information']
            );
        }

        if (!empty($data['education'])) {
            $believer->education()->updateOrCreate(
                ['believer_id' => $believer->id],
                $data['education']
            );
        }

        if (!empty($data['profession'])) {
            $believer->profession()->updateOrCreate(
                ['believer_id' => $believer->id],
                $data['profession']
            );
        }

        if (!empty($data['responsibility'])) {
            $believer->responsibility()->updateOrCreate(
                ['believer_id' => $believer->id],
                $data['responsibility']
            );
        }
    }

    /**
     * Relations Many-to-Many
     */
    private function handleManyToManyRelations(Believer $believer, array $data): void
    {
        // LANGUAGES
        if (!empty($data['languages']) && is_array($data['languages'])) {
            $languages = [];

            foreach ($data['languages'] as $lang) {
                if (!empty($lang['language_id'])) {
                    $languages[$lang['language_id']] = [
                        'spoken' => !empty($lang['spoken']),
                        'written' => !empty($lang['written']),
                    ];
                }
            }

            $believer->languages()->sync($languages);

        } else {
            $believer->languages()->sync([]);
        }

        // GROUPS
        if (!empty($data['groups']) && is_array($data['groups'])) {
            $groups = [];

            foreach ($data['groups'] as $grp) {
                if (!empty($grp['group_id'])) {
                    $groups[$grp['group_id']] = [
                        'role' => $grp['role'] ?? null,
                        'joined_at' => $grp['joined_at'] ?? null,
                    ];
                }
            }

            $believer->groups()->sync($groups);
        } else {
            $believer->groups()->sync([]);
        }

        // DEPARTMENTS
        if (method_exists($believer, 'departments')) {
            if (isset($data['departments']) && is_array($data['departments'])) {
                $believer->departments()->sync($data['departments']);
            }
        }
    }
}