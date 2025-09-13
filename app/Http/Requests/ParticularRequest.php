<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ParticularRequest extends FormRequest
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
            'genero' => 'required|in:Femenino,Masculino',
            'grado' => 'required|string|max:45',
        ];
    }

    public function messages()
    {
        return [
            'nombreCompleto.required' => 'El nombre completo es obligatorio.',
            'nombreCompleto.string' => 'El nombre completo debe ser una cadena de texto.',
            'nombreCompleto.max' => 'El nombre completo no debe exceder los 100 caracteres.',

            'genero.required' => 'El género es obligatorio.',
            'genero.in' => 'El género debe ser "Femenino" o "Masculino".',

            'grado.required' => 'El grado es obligatorio.',
            'grado.string' => 'El grado debe ser una cadena de texto.',
            'grado.max' => 'El grado no debe exceder los 45 caracteres.',
        ];
    }
}
