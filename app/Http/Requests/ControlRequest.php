<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ControlRequest extends FormRequest
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
            'acProrroga' => ['required', 'in:Si,No'],
            'acAuxilio' => ['required', 'in:Si,No'],
            'acRegularizacion' => ['required', 'in:Si,No'],
            'acRequerimiento' => ['required', 'in:Si,No'],
            'acOficioReque' => ['required', 'in:Si,No'],
            'acConclusion' => ['required', 'in:Si,No'],
            'comentarios' => ['nullable', 'string'],
            'numero' => ['required', 'string', 'max:45',
                Rule::unique(table:'control', column:'numero')->ignore($this->route(param: 'id'), 'consecutivo'),
            ]
        ];
    }

    public function messages()
    {
        return [
            'acProrroga.required' => 'El campo "Acuerdo de Prórroga" es obligatorio.',
            'acProrroga.in' => 'El campo "Acuerdo de Prórroga" solo puede ser "Si" o "No".',
            'acAuxilio.required' => 'El campo "Acuerdo de Auxilio" es obligatorio.',
            'acAuxilio.in' => 'El campo "Acuerdo de Auxilio" solo puede ser "Si" o "No".',
            'acRegularizacion.required' => 'El campo "Acuerdo de Regularización" es obligatorio.',
            'acRegularizacion.in' => 'El campo "Acuerdo de Regularización" solo puede ser "Si" o "No".',
            'acRequerimiento.required' => 'El campo "Acuerdo de Requerimiento" es obligatorio.',
            'acRequerimiento.in' => 'El campo "Acuerdo de Requerimiento" solo puede ser "Si" o "No".',
            'acOficioReque.required' => 'El campo "Oficio de Requerimiento" es obligatorio.',
            'acOficioReque.in' => 'El campo "Acuerdo de Oficio de Requerimiento" solo puede ser "Si" o "No".',
            'acConclusion.required' => 'El campo "Acuerdo de Conclusión" es obligatorio.',
            'acConclusion.in' => 'El campo "Acuerdo de Conclusión" solo puede ser "Si" o "No".',
            'comentarios.string' => 'El campo "Comentarios" debe ser un texto válido.',
            'numero.required' => 'El campo "Número" es obligatorio.',
            'numero.unique' => 'El expediente seleccionado ya tiene un control.'
        ];
    }

}
