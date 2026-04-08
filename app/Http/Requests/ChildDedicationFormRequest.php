<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\ChildDedication;

class ChildDedicationFormRequest extends FormRequest
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
            'father_id' => 'required|exists:believers,id',
            'mother_id' => 'required|exists:believers,id',
            'father_name' => 'nullable|string|max:255',
            'mother_name' => 'nullable|string|max:255',
            'demande_date' => 'required|date',
            'dedication_date' => 'required|date',
            'child_lastname' => 'required|string|max:255',
            'child_firstname' => 'required|string|max:255',
            'gender' => 'required|string|in:' . implode(',', ChildDedication::child_gender()),
            'child_birthdate' => 'required|date',
            'child_birthplace' => 'required|string|max:255',
        ];
    }
}
