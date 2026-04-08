<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\Believer;
use App\Models\ChurchInformation;

class BelieverFormRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $believerId = $this->route('believer')?->id;
        
        return [
            // BELIEVER
            'lastname' => 'required|string|max:100',
            'firstname' => 'required|string|max:100',
            'gender' => 'required|in:' . implode(',', Believer::genders()),
            'marital_status' => 'required|in:' . implode(',', Believer::maritalStatus()),
            'spouse_name' => 'nullable|string|max:100',
            'marriage_date' => 'nullable|date',
            'birth_date' => 'required|date',
            'birth_place' => 'required|string|max:100',

            'ethnicity' => 'required|string|max:100',
            'nationality' => 'required|string|max:100',
            'number_of_children' => 'nullable|integer|min:0',
            'cni_number' => 'nullable|string|max:100',

            // ADDRESS
            'address' => 'nullable|array',
            'address.whatsapp_number' => ['nullable', 'regex:/^[0-9]{10}$/'],
            'address.phone_number' => ['nullable', 'regex:/^[0-9]{10}$/'],
            'address.email' => 'nullable|email|max:100',
            'address.commune' => 'nullable|string|max:100',
            'address.quartier' => 'nullable|string|max:100',
            'address.sous_quartier' => 'nullable|string|max:100',

            // CHURCH INFORMATION
            'church_information' => 'required|array',
            'church_information.connaissance_eglise' => 'nullable|string|max:100',
            'church_information.original_church' => 'nullable|string|max:100',
            'church_information.arrival_year' => 'nullable|digits:4',
            'church_information.conversion_date' => 'nullable|date',
            'church_information.conversion_place' => 'nullable|string|max:100',
            'church_information.baptised' => 'required|in:' . implode(',', ChurchInformation::baptismStatus()),
            'church_information.baptism_date' => 'nullable|date',
            'church_information.baptism_place' => 'nullable|string|max:100',
            'church_information.baptism_pastor' => 'nullable|string|max:100',
            'church_information.baptism_card_number' => 'nullable|string|max:100',
            'church_information.membership_card_number' => 'nullable|string|max:100',

            // EDUCATION
            'education' => 'nullable|array',
            'education.level_of_education' => 'nullable|string|max:100',
            'education.degree' => 'nullable|string|max:100',
            'education.qualification' => 'nullable|string|max:100',

            // PROFESSION
            'profession' => 'nullable|array',
            'profession.profession' => 'nullable|string|max:100',
            'profession.fonction' => 'nullable|string|max:100',
            'profession.company' => 'nullable|string|max:100',
            'profession.professional_contact' => 'nullable|string|max:100',

            // RESPONSABILITIES
            'responsibility' => 'nullable|array',
            'responsibility.old' => 'nullable|string|max:255',
            'responsibility.current' => 'nullable|string|max:255',
            'responsibility.desired' => 'nullable|string|max:255',

            // LANGUAGES
            'languages' => 'nullable|array',
            'languages.*.language_id' => 'required_with:languages.*|distinct|exists:languages,id',
            'languages.*.spoken' => 'nullable|boolean',
            'languages.*.written' => 'nullable|boolean',

            // GROUPS
            'groups' => 'nullable|array',
            'groups.*.group_id' => 'nullable|exists:groups,id',
            'groups.*.role' => 'nullable|string|max:100',
            'groups.*.joined_at' => 'nullable|date',
        ];
    }
}
