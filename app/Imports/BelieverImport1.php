<?php

namespace App\Imports;

use App\Models\Believer;
use App\Models\Language;
use App\Services\BelieverService;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\ToCollection;

use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\SkipsEmptyRows;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Concerns\SkipsFailures;

use Maatwebsite\Excel\Events\BeforeImport;
use Maatwebsite\Excel\Events\AfterImport;

use Carbon\Carbon;
use Illuminate\Validation\Rule;
use PhpOffice\PhpSpreadsheet\Shared\Date;

class BelieverImport implements ToModel, ToCollection, WithHeadingRow, WithValidation, SkipsEmptyRows, SkipsOnFailure
{
    use SkipsFailures;

    public function collection(Collection $rows)
    {
        $service = app(BelieverService::class);

        DB::transaction(function () use ($rows, $service) {
            foreach ($rows as $row) {
               $data = [
                    // BELIEVER
                    'lastname' => $row['lastname'],
                    'firstname' => $row['firstname'],
                    'gender' => $row['gender'],
                    'marital_status' => $row['marital_status'],
                    'birth_date' => $row['birth_date'],
                    'birth_place' => $row['birth_place'],
                    'ethnicity' => $row['ethnicity'],
                    'nationality' => $row['nationality'],
                    'number_of_children' => $row['number_of_children'] ?? null,
                    'cni_number' => $row['cni_number'] ?? null,

               // ADDRESS
                    'address' => [
                        'whatsapp_number' => $row['whatsapp_number'] ?? null,
                        'phone_number' => $row['phone_number'] ?? null,
                        'email' => $row['email'] ?? null,
                        'commune' => $row['commune'] ?? null,
                        'quartier' => $row['quartier'] ?? null,
                        'sous_quartier' => $row['sous_quartier'] ?? null,
                    ],

                    // CHURCH INFORMATION
                    'church_information' => [
                        'connaissance_eglise' => $row['connaissance_eglise'] ?? null,
                        'original_church' => $row['original_church'] ?? null,
                        'arrival_year' => $row['arrival_year'] ?? null,
                        'conversion_date' => $row['conversion_date'] ?? null,
                        'conversion_place' => $row['conversion_place'] ?? null,
                        'baptised' => $row['baptised'] ?? null,
                        'baptism_date' => $row['baptism_date'] ?? null,
                        'baptism_place' => $row['baptism_place'] ?? null,
                        'baptism_pastor' => $row['baptism_pastor'] ?? null,
                        'baptism_card_number' => $row['baptism_card_number'] ?? null,
                        'membership_card_number' => $row['membership_card_number'] ?? null,
                    ],

                    // EDUCATION
                    'education' => [
                        'level_of_education' => $row['level_of_education'] ?? null,
                        'degree' => $row['degree'] ?? null,
                        'qualification' => $row['qualification'] ?? null,
                    ],

                    // PROFESSION
                    'profession' => [
                        'fonction' => $row['fonction'] ?? null,
                        'company' => $row['company'] ?? null,
                        'professional_contact' => $row['professional_contact'] ?? null,
                    ],

                    // RESPONSIBILITY
                    'responsibility' => [
                        'old' => $row['responsibility_old'] ?? null,
                        'current' => $row['responsibility_current'] ?? null,
                        'desired' => $row['responsibility_desired'] ?? null,
                    ],

                    // LANGUAGES
                    'languages' => $this->parseLanguages($row['languages'] ?? null),
                ];

                $service->create($data);
            }
        });
    }

    private function parseLanguages(?string $value)
    {
        if (empty($value)) {
            return [];
        }

        $result = [];

        $items = explode('|', $value);

        foreach ($items as $item) {
            $parts = explode(':', $item);
            
            if (count($parts) < 3) {
                continue; // Skip invalid entries
            }

            [$languageName, $spoken, $written] = $parts;

            $language = Language::where('name', trim($languageName))->first();

            if ($language) {
                $result[] = [
                    'language_id' => $language->id,
                    'spoken' => trim($spoken) === '1',
                    'written' => trim($written) === '1',
                ];
            }
        }
        return $result;
    }

    public function rules(): array
    {
        return [
            '*.lastname' => 'required|string|max:100',
            '*.firstname' => 'required|string|max:100',
            '*.gender' => 'required|in:Masculin,Féminin',
            '*.marital_status' => 'required|string|max:100',
            '*.birth_date' => 'required',
            '*.birth_place' => 'required|string|max:100',
            '*.ethnicity' => 'required|string|max:100',
            '*.nationality' => 'required|string|max:100',
            '*.number_of_children' => 'nullable|integer|min:0',
            '*.cni_number' => 'nullable|string|max:100',

            '*.whatsapp_number' => 'nullable|regex:/^[0-9]{10}$/',
            '*.phone_number' => 'nullable|regex:/^[0-9]{10}$/',
            '*.email' => 'nullable|email|max:100',

            '*.baptised' => 'nullable|in:Oui,Non',
        ];
    }

    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */

    public function headingRow(): int
    {
        return 1;
    }

    public function prepareForValidation($data, $index)
    {
        return array_map(fn ($value) =>
            is_string($value) ? trim($value) : $value,
            $data
        );
    }

    // public function rules(): array
    // {
    //     return [
    //         '*.lastname' => ['required', 'string'],
    //         '*.firstname' => ['required', 'string'],
    //         '*.civility' => ['required', 'string', Rule::in(['Monsieur', 'Madame', 'Mademoiselle'])],
    //         '*.marital_status' => ['required', 'string', Rule::in(['Célibataire', 'Marié(e)', 'Divorcé(e)', 'Veuf(ve)'])],
    //         '*.birth_date' => ['nullable'],
    //         '*.city_of_birth' => ['required', 'string'],

    //         '*.baptized' => ['required', 'string', Rule::in(['Oui', 'Non'])],
    //         '*.baptism_date' => ['nullable'],
    //         '*.diplome' => ['nullable', 'string'],
    //         '*.profession' => ['required', 'string'],
    //         '*.qualification' => ['nullable', 'string'],
    //         '*.number_of_children' => ['nullable', 'integer', 'min:0'],

    //         '*.neighborhood' => ['required', 'string'],
    //         '*.church_relationship' => ['nullable', 'string'],
    //         '*.person_to_contact' => ['required', 'regex:/^[0-9]{10}$/'],
    //         '*.baptism_card_number' => ['nullable', 'string'],
    //         '*.membership_card_number' => ['nullable', 'string'],

    //         '*.contact' => ['required', 'regex:/^[0-9]{10}$/'],
    //         '*.email' => ['nullable', 'email'],
    //         '*.original_church' => ['nullable', 'string'],
    //         '*.arrival_year' => ['nullable', 'integer', 'min:0'], 
    //     ];
    // }

    private function formatDate($value)
    {
        if ($value === null || $value === '') {
            return null;
        }

        if (is_numeric($value)) {
            return Carbon::instance(
                Date::excelToDateTimeObject($value)
            )->format('Y-m-d');
        }

        $value = trim($value);

        if (preg_match('/^\d{2}\/\d{2}\/\d{4}$/', $value)) {
            return Carbon::createFromFormat('d/m/Y', $value)->format('Y-m-d');
        }

        return Carbon::parse($value)->format('Y-m-d');
    }

    public function model(array $row)
    {
        return new Believer([
            'lastname'               => $row['lastname'],
            'firstname'              => $row['firstname'],
            'civility'               => $row['civility'],
            'marital_status'         => $row['marital_status'],
            'birth_date'             => $this->formatDate($row['birth_date']),
            'city_of_birth'          => $row['city_of_birth'],

            'baptized'               => $row['baptized'],
            'baptism_date'           => $this->formatDate($row['baptism_date']),
            'diplome'                => $row['diplome'],
            'profession'             => $row['profession'],
            'qualification'          => $row['qualification'],

            'number_of_children'     => $row['number_of_children'],
            'neighborhood'           => $row['neighborhood'],
            'church_relationship'    => $row['church_relationship'],
            'person_to_contact'      => $row['person_to_contact'],
            'baptism_card_number'    => $row['baptism_card_number'],
            'membership_card_number' => $row['membership_card_number'],

            'contact'                => $row['contact'],
            'email'                  => $row['email'],
            'original_church'        => $row['original_church'],
            'arrival_year'           => $row['arrival_year'],
        ]);
    }
}
