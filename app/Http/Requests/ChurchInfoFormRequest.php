<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ChurchInfoFormRequest extends FormRequest
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
            'organisation' => 'required|string|max:10',
            'organisation_name' => 'required|string|max:255',
            'district' => 'required|string|max:255',
            'church_name' => 'required|string|max:255',
            'authorization' => 'required|string|max:255',
            
            'address' => 'required|string|max:500',
            'pastor_phone_number' => ['required', 'regex:/^[0-9]{10}$/'],
            'secretary_phone_number' => ['required', 'regex:/^[0-9]{10}$/'],
            'church_email' => 'required|email|max:255',
            'pastor_email' => 'required|email|max:255',
            'localisation' => 'required|string|max:500',

            'photo_path' => 'required|image|mimes:jpg,jpeg,png,|max:2048',
        ];
    }
}
