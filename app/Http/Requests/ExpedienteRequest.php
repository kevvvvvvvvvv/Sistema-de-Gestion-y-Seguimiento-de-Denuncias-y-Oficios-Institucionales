<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ExpedienteRequest extends FormRequest
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
            'numero' => ['required', 'string', 'max:45',
                Rule::unique(table:'expediente', column:'numero')->ignore($this->route(param: 'id'), 'numero'),
            ],
            'ofRequerimiento' => ['required', 'string', 'max:100'],
            'fechaRequerimiento' => ['required', 'date'],
            'ofRespuesta' => ['nullable', 'string', 'max:100'],
            'fechaRespuesta' => ['nullable', 'date'],
            'fechaRecepcion' => ['nullable', 'date'],
            'idServidor' => ['required', 'integer'],
        ];
    }

    public function messages(): array
    {
        return [
            'numero.unique' => 'Este número de expediente ya está en uso.',
            'numero.required' => 'El campo "Número de expediente" es obligatorio.',
            'numero.string' => 'El campo "Número de expediente" debe ser un texto válido.',
            'numero.max' => 'El campo "Número de expediente" no debe superar los 45 caracteres.',
            'ofRequerimiento.required' => 'El campo "Oficio de Requerimiento" es obligatorio.',
            'ofRequerimiento.string' => 'El campo "Oficio de Requerimiento" debe ser un texto válido.',
            'ofRequerimiento.max' => 'El campo "Oficio de Requerimiento" no debe superar los 100 caracteres.',
            'fechaRequerimiento.required' => 'La "Fecha de Requerimiento" es obligatoria.',
            'fechaRequerimiento.date' => 'La "Fecha de Requerimiento" debe ser una fecha válida.',
            'ofRespuesta.string' => 'El campo "Oficio de Respuesta" debe ser un texto válido.',
            'ofRespuesta.max' => 'El campo "Oficio de Respuesta" no debe superar los 100 caracteres.',
            'fechaRespuesta.date' => 'La "Fecha de Respuesta" debe ser una fecha válida.',
            'fechaRecepcion.date' => 'La "Fecha de Recepción" debe ser una fecha válida.',
            'idServidor.required' => 'El campo "Servidor" es obligatorio.',
        ];
    }
}
