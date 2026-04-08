<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreProgrammeRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    protected function prepareForValidation()
    {
        $this->merge([
            'programme' => array_merge(
                $this->input('programme', []),
                [
                    'is_active' => $this->boolean('programme.is_active'),
                ]
            ),
        ]);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            // Programme
            'programme.title' => 'required|string|max:255',
            'programme.start_date' => 'required|date',
            'programme.end_date' => 'required|date|after:programme.start_date',
            'programme.description' => 'nullable|string|max:255',
            'programme.is_active' => 'boolean',

            // Thème principal
            'theme_principal.theme' => 'required|string|max:255',
            'theme_principal.text_biblique_principal' => 'nullable|string',

            // Sous-thèmes
            'sous_themes' => 'required|array|min:1',
            'sous_themes.*.sous_theme' => 'required|string|max:255',
            'sous_themes.*.text_biblique' => 'required|string|max:255',
        ];
    }
}
