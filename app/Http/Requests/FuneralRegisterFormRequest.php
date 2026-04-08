<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\FuneralRegister;

class FuneralRegisterFormRequest extends FormRequest
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
            'believer_id' => 'required|exists:believers,id',

            'parent_firstname' => 'required|string|max:255',
            'parent_lastname' => 'required|string|max:255',

            'death_date' => 'required|date',
            'burial_place' => 'required|string|max:255',
            'family_relationship' => 'required|string|max:255',

            'cause_of_death' => 'nullable|string|max:255',

            'funeral_date' => 'required|date',
            'funeral_place' => 'required|string|max:255',
            // Assistance eglise
            'loincloths_number' => 'required|integer|min:0',
            'amount_paid' => 'required|numeric|min:0',
            // Assistance fidèles
            'nbre_pagne' => 'required|integer|min:0',
            'cash_amount' => 'required|numeric|min:0',
        ];
    }
}
