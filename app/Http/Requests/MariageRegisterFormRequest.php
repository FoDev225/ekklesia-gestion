<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MariageRegisterFormRequest extends FormRequest
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
        return [
            'groom_is_member' => 'required|boolean',
            'bride_is_member' => 'required|boolean',
            
            'groom_id' => 'required_if:groom_is_member,1|nullable|exists:believers,id',
            'groom_name' => 'required_if:groom_is_member,0|nullable|string|max:100',
            'groom_birthdate' => 'required_if:groom_is_member,0|nullable|date',
            'groom_birth_place' => 'required_if:groom_is_member,0|nullable|string|max:100',
            'groom_bapistism_date' => 'nullable|date',
            'groom_bapistism_place' => 'nullable|string|max:100',
            'baptism_officer_groom' => 'nullable|string|max:100',
            'groom_profession' => 'nullable|string|max:100',
            'groom_photo' => 'nullable|image|max:2048',

            'bride_id' => 'required_if:bride_is_member,1|nullable|exists:believers,id',
            'bride_name' => 'required_if:bride_is_member,0|nullable|string|max:100',
            'bride_birthdate' => 'required_if:bride_is_member,0|nullable|date',
            'bride_birth_place' => 'required_if:bride_is_member,0|nullable|string|max:100',
            'bride_bapistism_date' => 'nullable|date',
            'bride_bapistism_place' => 'nullable|string|max:100',
            'baptism_officer_bride' => 'nullable|string|max:100',
            'bride_profession' => 'nullable|string|max:100',
            'bride_photo' => 'nullable|image|max:2048',

            'civil_marriage_date' => 'required|date',
            'civil_marriage_place' => 'required|string|max:100',

            'religious_marriage_date' => 'required|date',
            'religious_marriage_place' => 'required|string|max:100',
            'wedding_mc' => 'nullable|string|max:100',
            'wedding_preacher' => 'required|string|max:100',
            'hand_bible' => 'nullable|string|max:100',
            'officiant' => 'required|string|max:100',
            
            'groom_witness' => 'required|string|max:100',
            'groom_witness_profession' => 'nullable|string|max:100',

            'bride_witness' => 'required|string|max:100',
            'bride_witness_profession' => 'nullable|string|max:100',
        ];
    }
}
