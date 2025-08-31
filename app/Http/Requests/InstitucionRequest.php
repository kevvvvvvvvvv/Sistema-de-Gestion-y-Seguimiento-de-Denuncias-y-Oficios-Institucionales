<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class InstitucionRequest extends FormRequest
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
            'nombreCompleto' => 'required|string|max:100',
            'siglas' => 'required|string|max:45'
        ];
    }

    public function messages()
    {
        return [
            'nombreCompleto.required' => 'El nombre de la institución es obligatorio.',
            'nombreCompleto.string' => 'El nombre de la institución debe ser una cadena de texto.',
            'nombreCompleto.max' => 'El nombre de la institución no debe exceder los 100 caracteres.',
            'siglas.required' => 'Las siglas son obligatorias.',
            'siglas.string' => 'Las siglas deben ser una cadena de texto.',
            'siglas.max' => 'Las siglas no deben exceder los 45 caracteres.',
        ];
    }
}
