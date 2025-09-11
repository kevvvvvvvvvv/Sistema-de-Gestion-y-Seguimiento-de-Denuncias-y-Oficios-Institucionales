<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class BajaRequest extends FormRequest
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
            'idServidor' => ['required',
                Rule::unique(table:'baja', column:'idServidor')->ignore($this->route(param: 'id'), 'idBaja')],
            'numero' => 'nullable|string',
            'fechaBaja' => 'required|date',
            'descripcion' => 'required|string'
        ];
    }

    public function messages()
    {
        return [
            'idServidor.required' => 'El campo Servidor Público es obligatorio.',
            'idServidor.unique' => 'El Servidor Público seleccionado ya tiene una baja registrada.',
            'numero.required' => 'El campo Número de Expediente es obligatorio.',
            'numero.not_in' => 'El Servidor Público seleccionado no tiene un expediente registrado.',
            'fechaBaja.required' => 'El campo Fecha de Baja es obligatorio.',
            'fechaBaja.date' => 'El campo Fecha de Baja debe ser una fecha válida.',
            'descripcion.required' => 'El campo Descripción es obligatorio.',
            'descripcion.string' => 'El campo Descripción debe ser una cadena de texto.'
        ];
    }
}
