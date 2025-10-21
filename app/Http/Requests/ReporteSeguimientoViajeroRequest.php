<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ReporteSeguimientoViajeroRequest extends FormRequest
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
            'fecha_inicio' => 'nullable',
            'fecha_fin'    => 'nullable|after:fecha_inicio'
        ];
    }

    public function messages()
    {
        return [
            'fecha_fin.after' => 'La fecha de fin debe ser una fecha posterior a la fecha de inicio.',
        ];
    }
}
