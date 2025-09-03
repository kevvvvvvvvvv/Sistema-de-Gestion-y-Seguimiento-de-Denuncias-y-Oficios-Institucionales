<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DepartamentoRequest extends FormRequest
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
            'nombre' => 'required|string|max:100',
            'idInstitucion' => 'required'
        ];
    }

    public function messages()
    {
        return [
            'nombre.required' => 'El nombre del departamento es obligatorio.',
            'nombre.string' => 'El nombre del departamento debe ser una cadena de texto.',
            'nombre.max' => 'El nombre del departamento no debe exceder los 100 caracteres.',
            'idInstitucion.required' => 'La insitución es obligatoria.'
        ];
    }
}
