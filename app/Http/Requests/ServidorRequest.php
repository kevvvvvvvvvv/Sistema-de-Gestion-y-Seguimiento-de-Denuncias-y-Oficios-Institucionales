<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ServidorRequest extends FormRequest
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
    public function rules() 
    {
        $rules = [
            'nombreCompleto' => 'required|string|max:100',
            'genero' => 'required',
            'grado' => 'required|string|max:45',
            'fechaIngreso' => 'nullable|date',
            'puesto' => 'nullable|string|max:100',
            'nivel' => 'nullable|string|max:45',
            'correo' => 'nullable|email|max:100',
            'telefono' => 'nullable|string|max:45|regex:/^[0-9]+$/',
            'descripcion' => 'nullable',
            'idInstitucion' => 'required|integer',
            'idDepartamento' => 'required|integer'
        ];

        if($this->routeIs('servidores.store')) {
            $rules['estatus'] = 'required|string|in:Alta';
        }else{
            $rules['estatus'] = 'required|string';
        }

        return $rules;
    }

    public function messages()
    {
        return [
            'estatus.required' => 'El estatus es obligatorio.',
            'estatus.string' => 'El estatus debe ser una cadena de texto.',
            'estatus.in' => 'El estatus solo puede ser Alta, la baja de un servidor se gestiona en el módulo de Bajas.',
            'nombreCompleto.required' => 'El nombre completo es obligatorio.',
            'nombreCompleto.string' => 'El nombre completo debe ser una cadena de texto.',
            'nombreCompleto.max' => 'El nombre completo no debe exceder los 100 caracteres.',
            'genero.required' => 'El género es obligatorio.',
            'grado.required' => 'El grado es obligatorio.',
            'grado.string' => 'El grado debe ser una cadena de texto.',
            'grado.max' => 'El grado no debe exceder los 45 caracteres.',
            'fechaIngreso.date' => 'La fecha de ingreso no es una fecha válida.',
            'puesto.required' => 'El puesto es obligatorio.',
            'puesto.string' => 'El puesto debe ser una cadena de texto.',
            'puesto.max' => 'El puesto no debe exceder los 100 caracteres.',
            'nivel.required' => 'El nivel es obligatorio.',
            'nivel.string' => 'El nivel debe ser una cadena de texto.',
            'nivel.max' => 'El nivel no debe exceder los 100 caracteres.',
            'correo.email' => 'El correo no es un correo válido.',
            'correo.max' => 'El correo no debe exceder los 100 caracteres.',
            'telefono.string' => 'El teléfono debe ser una cadena de texto.',
            'telefono.max' => 'El teléfono no debe exceder los 45 caracteres.',
            'telefono.regex' => 'El teléfono solo debe contener números.',
            'estatus.required' => 'El estatus es obligatorio.',
            'idInstitucion.required' => 'La institución es obligatoria.',
            'idInstitucion.integer' => 'La institución no es válida.',
            'idDepartamento.required' => 'El departamento es obligatorio.',
            'idDepartamento.integer' => 'El departamento no es válido.'
        ];
    }
}
