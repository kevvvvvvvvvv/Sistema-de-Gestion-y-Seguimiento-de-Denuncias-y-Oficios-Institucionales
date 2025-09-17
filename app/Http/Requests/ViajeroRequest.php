<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ViajeroRequest extends FormRequest
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
            'numOficio'      => 'required|string|max:100',
            'fechaCreacion'  => 'required|date',
            'fechaLlegada'   => 'required|date',
            'asunto'         => 'required|string|max:255',
            'resultado'      => 'nullable|string|max:255',
            'instruccion'    => 'nullable|string|max:255',
            'fechaEntrega'   => 'nullable|date',
            'idUsuario'      => 'nullable integer',
        ];
    }

    public function messages()
    {
        return [
            'numOficio.required'     => 'El número de oficio es obligatorio.',
            'numOficio.string'       => 'El número de oficio debe ser una cadena de texto.',
            'numOficio.max'          => 'El número de oficio no debe exceder los 100 caracteres.',

            'fechaCreacion.required' => 'La fecha de creación es obligatoria.',
            'fechaCreacion.date'     => 'La fecha de creación no es válida.',

            'fechaLlegada.required'  => 'La fecha de llegada es obligatoria.',
            'fechaLlegada.date'      => 'La fecha de llegada no es válida.',

            'asunto.required'        => 'El asunto es obligatorio.',
            'asunto.string'          => 'El asunto debe ser una cadena de texto.',
            'asunto.max'             => 'El asunto no debe exceder los 255 caracteres.',

            'resultado.string'       => 'El resultado debe ser una cadena de texto.',
            'resultado.max'          => 'El resultado no debe exceder los 255 caracteres.',

            'instruccion.string'     => 'La instrucción debe ser una cadena de texto.',
            'instruccion.max'        => 'La instrucción no debe exceder los 255 caracteres.',

            'fechaEntrega.date'      => 'La fecha de entrega no es válida.',

            'idUsuario.integer'      => 'El usuario no es válido.',
        ];
    }
}
