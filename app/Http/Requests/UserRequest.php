<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UserRequest extends FormRequest
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
            'nombre' => 'required|string|max:100',
            'apPaterno' => 'required|string|max:100',
            'apMaterno' => 'required|string|max:100',
            'email' => [
                'required',
                'email', 
                Rule::unique(table:'users', column:'email')->ignore($this->route(param: 'id'), 'idUsuario'),
            ],
            'role' => 'required',
        ];

        if($this->routeIs('users.store')) {
            $rules['password'] = 'required|string|min:8';
        }else{
            $rules['password'] = 'nullable|string|min:8';
        }

        return $rules;
    }

    public function messages()
    {
        return [
            'nombre.required' => 'El nombre es obligatorio.',
            'nombre.string' => 'El nombre debe ser una cadena de texto.',
            'nombre.max' => 'El nombre no debe exceder los 100 caracteres.',
            'apPaterno.required' => 'El apellido paterno es obligatorio.',
            'apPaterno.string' => 'El apellido paterno debe ser una cadena de texto.',
            'apPaterno.max' => 'El apellido paterno no debe exceder los 100 caracteres.',
            'apMaterno.required' => 'El apellido materno es obligatorio.',
            'apMaterno.string' => 'El apellido materno debe ser una cadena de texto.',
            'apMaterno.max' => 'El apellido materno no debe exceder los 100 caracteres.',
            'email.required' => 'El correo electrónico es obligatorio.',
            'email.email' => 'El correo electrónico debe ser una dirección válida.',
            'email.unique' => 'El correo electrónico ya está en uso.',
            'password.required' => 'La contraseña es obligatoria.',
            'password.min' => 'La contraseña debe tener al menos 8 caracteres.',
            'role.required' => 'El rol es obligatorio.',
        ];
    }
}
