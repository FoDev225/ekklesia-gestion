<?php

namespace App\Imports;

use App\Models\Believer;
use App\Models\Language;
use App\Services\BelieverService;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\SkipsEmptyRows;

use PhpOffice\PhpSpreadsheet\Shared\Date as ExcelDate;
use Carbon\Carbon;

class BelieverImport implements ToCollection, WithHeadingRow, SkipsEmptyRows
{
    protected BelieverService $service;

    public array $report = [];
    public int $successCount = 0;
    public int $errorCount = 0;
    public int $ignoredCount = 0;
    public int $updatedCount = 0;

    protected bool $updateIfExists;

    public function __construct(bool $updateIfExists = false)
    {
        $this->service = app(BelieverService::class);
        $this->updateIfExists = $updateIfExists;
    }

    public function collection(Collection $rows)
    {
        foreach ($rows as $index => $row) {
            $excelRow = $index + 2; // ligne réelle Excel (si entêtes ligne 1)

            $row = $row->toArray();

            // Ignorer vraies lignes vides / sales
            if ($this->isRowCompletelyEmpty($row)) {
                continue;
            }

            // Nettoyage / normalisation
            $row = $this->normalizeRow($row);

            // Validation
            $validator = Validator::make($row, [
                'lastname' => 'required|string|max:100',
                'firstname' => 'required|string|max:100',
                'gender' => ['required', Rule::in(['Masculin', 'Féminin'])],
                'marital_status' => ['required', Rule::in(['Célibataire', 'Marié(e)', 'Veuf(ve)', 'Divorcé(e)'])],
                'birth_date' => 'required|date',
                'birth_place' => 'required|string|max:100',
                'ethnicity' => 'nullable|string|max:100',
                'nationality' => 'nullable|string|max:100',
                'number_of_children' => 'nullable|integer|min:0',
                'cni_number' => 'nullable|string|max:100',

                'whatsapp_number' => 'nullable|string|max:20',
                'phone_number' => 'nullable|string|max:20',
                'email' => 'nullable|email|max:100',
                'commune' => 'nullable|string|max:100',
                'quartier' => 'nullable|string|max:100',
                'sous_quartier' => 'nullable|string|max:100',

                'connaissance_eglise' => 'nullable|string|max:100',
                'original_church' => 'nullable|string|max:100',
                'arrival_year' => 'nullable|digits:4',
                'conversion_date' => 'nullable|date',
                'conversion_place' => 'nullable|string|max:100',
                'baptised' => ['nullable', Rule::in(['Oui', 'Non'])],
                'baptism_date' => 'nullable|date',
                'baptism_place' => 'nullable|string|max:100',
                'baptism_pastor' => 'nullable|string|max:100',
                'baptism_card_number' => 'nullable|string|max:100',
                'membership_card_number' => 'nullable|string|max:100',

                'level_of_education' => 'nullable|string|max:100',
                'degree' => 'nullable|string|max:100',
                'qualification' => 'nullable|string|max:100',

                'fonction' => 'nullable|string|max:100',
                'company' => 'nullable|string|max:100',
                'professional_contact' => 'nullable|string|max:100',

                'responsibility_old' => 'nullable|string|max:255',
                'responsibility_current' => 'nullable|string|max:255',
                'responsibility_desired' => 'nullable|string|max:255',

                'languages' => 'nullable|string',
            ]);

            if ($validator->fails()) {
                $this->errorCount++;
                $this->report[] = [
                    'line' => $excelRow,
                    'status' => 'Erreur',
                    'name' => trim(($row['lastname'] ?? '') . ' ' . ($row['firstname'] ?? '')),
                    'message' => implode(' | ', $validator->errors()->all()),
                ];
                continue;
            }

            try {
                // Détection doublon
                $existingBeliever = Believer::where('lastname', $row['lastname'])
                    ->where('firstname', $row['firstname'])
                    ->whereDate('birth_date', $row['birth_date'])
                    ->first();

                $payload = $this->buildPayload($row);

                if ($existingBeliever) {
                    if ($this->updateIfExists) {
                        $this->service->update($existingBeliever, $payload);

                        $this->updatedCount++;
                        $this->report[] = [
                            'line' => $excelRow,
                            'status' => 'Mis à jour',
                            'name' => $row['lastname'] . ' ' . $row['firstname'],
                            'message' => 'Fidèle existant mis à jour.',
                        ];
                    } else {
                        $this->ignoredCount++;
                        $this->report[] = [
                            'line' => $excelRow,
                            'status' => 'Ignoré',
                            'name' => $row['lastname'] . ' ' . $row['firstname'],
                            'message' => 'Fidèle déjà existant, import ignoré.',
                        ];
                    }

                    continue;
                }

                $this->service->create($payload);

                $this->successCount++;
                $this->report[] = [
                    'line' => $excelRow,
                    'status' => 'Importé',
                    'name' => $row['lastname'] . ' ' . $row['firstname'],
                    'message' => 'Import réussi.',
                ];
            } catch (\Throwable $e) {
                $this->errorCount++;
                $this->report[] = [
                    'line' => $excelRow,
                    'status' => 'Erreur',
                    'name' => trim(($row['lastname'] ?? '') . ' ' . ($row['firstname'] ?? '')),
                    'message' => $e->getMessage(),
                ];
            }
        }
    }

    private function buildPayload(array $row): array
    {
        return [
            'lastname' => $row['lastname'],
            'firstname' => $row['firstname'],
            'gender' => $row['gender'],
            'marital_status' => $row['marital_status'],
            'birth_date' => $row['birth_date'],
            'birth_place' => $row['birth_place'],
            'ethnicity' => $row['ethnicity'],
            'nationality' => $row['nationality'],
            'number_of_children' => $row['number_of_children'],
            'cni_number' => $row['cni_number'],

            'address' => [
                'whatsapp_number' => $row['whatsapp_number'],
                'phone_number' => $row['phone_number'],
                'email' => $row['email'],
                'commune' => $row['commune'],
                'quartier' => $row['quartier'],
                'sous_quartier' => $row['sous_quartier'],
            ],

            'church_information' => [
                'connaissance_eglise' => $row['connaissance_eglise'],
                'original_church' => $row['original_church'],
                'arrival_year' => $row['arrival_year'],
                'conversion_date' => $row['conversion_date'],
                'conversion_place' => $row['conversion_place'],
                'baptised' => $row['baptised'] ?? 'Non',
                'baptism_date' => $row['baptism_date'],
                'baptism_place' => $row['baptism_place'],
                'baptism_pastor' => $row['baptism_pastor'],
                'baptism_card_number' => $row['baptism_card_number'],
                'membership_card_number' => $row['membership_card_number'],
            ],

            'education' => [
                'level_of_education' => $row['level_of_education'],
                'degree' => $row['degree'],
                'qualification' => $row['qualification'],
            ],

            'profession' => [
                'fonction' => $row['fonction'],
                'company' => $row['company'],
                'professional_contact' => $row['professional_contact'],
            ],

            'responsibility' => [
                'old' => $row['responsibility_old'],
                'current' => $row['responsibility_current'],
                'desired' => $row['responsibility_desired'],
            ],

            'languages' => $this->parseLanguages($row['languages'] ?? null),
        ];
    }

    private function parseLanguages(?string $languagesRaw): array
    {
        if (empty($languagesRaw)) {
            return [];
        }

        $result = [];
        $items = explode('|', $languagesRaw);

        foreach ($items as $item) {
            $parts = array_map('trim', explode(':', $item));

            $languageName = $parts[0] ?? null;
            $spoken = strtolower($parts[1] ?? 'non') === 'oui';
            $written = strtolower($parts[2] ?? 'non') === 'oui';

            if (!$languageName) {
                continue;
            }

            $language = Language::where('name', $languageName)->first();

            if ($language) {
                $result[] = [
                    'language_id' => $language->id,
                    'spoken' => $spoken,
                    'written' => $written,
                ];
            }
        }

        return $result;
    }

    private function normalizeRow(array $row): array
    {
        $row['lastname'] = $this->normalizeString($row['lastname'] ?? null);
        $row['firstname'] = $this->normalizeString($row['firstname'] ?? null);
        $row['gender'] = $this->normalizeString($row['gender'] ?? null);
        $row['marital_status'] = $this->normalizeString($row['marital_status'] ?? null);
        $row['birth_place'] = $this->normalizeString($row['birth_place'] ?? null);
        $row['ethnicity'] = $this->normalizeString($row['ethnicity'] ?? null);
        $row['nationality'] = $this->normalizeString($row['nationality'] ?? null);
        $row['cni_number'] = $this->normalizeString($row['cni_number'] ?? null);

        $row['whatsapp_number'] = $this->normalizeString($row['whatsapp_number'] ?? null);
        $row['phone_number'] = $this->normalizeString($row['phone_number'] ?? null);
        $row['email'] = $this->normalizeString($row['email'] ?? null);
        $row['commune'] = $this->normalizeString($row['commune'] ?? null);
        $row['quartier'] = $this->normalizeString($row['quartier'] ?? null);
        $row['sous_quartier'] = $this->normalizeString($row['sous_quartier'] ?? null);

        $row['connaissance_eglise'] = $this->normalizeString($row['connaissance_eglise'] ?? null);
        $row['original_church'] = $this->normalizeString($row['original_church'] ?? null);
        $row['arrival_year'] = $this->normalizeYear($row['arrival_year'] ?? null);
        $row['conversion_place'] = $this->normalizeString($row['conversion_place'] ?? null);
        $row['baptised'] = $this->normalizeString($row['baptised'] ?? null);
        $row['baptism_place'] = $this->normalizeString($row['baptism_place'] ?? null);
        $row['baptism_pastor'] = $this->normalizeString($row['baptism_pastor'] ?? null);
        $row['baptism_card_number'] = $this->normalizeString($row['baptism_card_number'] ?? null);
        $row['membership_card_number'] = $this->normalizeString($row['membership_card_number'] ?? null);

        $row['level_of_education'] = $this->normalizeString($row['level_of_education'] ?? null);
        $row['degree'] = $this->normalizeString($row['degree'] ?? null);
        $row['qualification'] = $this->normalizeString($row['qualification'] ?? null);

        $row['fonction'] = $this->normalizeString($row['fonction'] ?? null);
        $row['company'] = $this->normalizeString($row['company'] ?? null);
        $row['professional_contact'] = $this->normalizeString($row['professional_contact'] ?? null);

        $row['responsibility_old'] = $this->normalizeString($row['responsibility_old'] ?? null);
        $row['responsibility_current'] = $this->normalizeString($row['responsibility_current'] ?? null);
        $row['responsibility_desired'] = $this->normalizeString($row['responsibility_desired'] ?? null);

        $row['languages'] = $this->normalizeString($row['languages'] ?? null);

        $row['birth_date'] = $this->normalizeDate($row['birth_date'] ?? null);
        $row['conversion_date'] = $this->normalizeDate($row['conversion_date'] ?? null);
        $row['baptism_date'] = $this->normalizeDate($row['baptism_date'] ?? null);

        return $row;
    }

    private function normalizeString($value): ?string
    {
        if ($value === null || $value === '') {
            return null;
        }

        return trim((string) $value);
    }

    private function normalizeYear($value): ?string
    {
        if ($value === null || $value === '') {
            return null;
        }

        return substr((string) $value, 0, 4);
    }

    private function normalizeDate($value): ?string
    {
        if (empty($value)) {
            return null;
        }

        try {
            if (is_numeric($value)) {
                return ExcelDate::excelToDateTimeObject($value)->format('Y-m-d');
            }

            return Carbon::parse($value)->format('Y-m-d');
        } catch (\Throwable $e) {
            return null;
        }
    }

    private function isRowCompletelyEmpty(array $row): bool
    {
        foreach ($row as $value) {
            if ($value !== null && trim((string) $value) !== '') {
                return false;
            }
        }

        return true;
    }
}