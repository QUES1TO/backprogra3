<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserRegisterRequest extends BaseFormRequest
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
            'name' => 'required|string',
            'email' => 'required|email|unique:users',
            'password' => 'required',
            'last_name' => 'required',
            'address' => 'required'
        ];
    }
    public function messages()
    {
        return [
            'nombre.required' => 'El campo nombre es obligatorio.',
            //'nombre.string' => 'El campo nombre debe ser una cadena de texto.',
            //'nombre.max' => 'El campo nombre no debe superar los :max caracteres.',
            'email.required' => 'El campo email es obligatorio.',
            'email.email' => 'El campo email debe ser una dirección de correo electrónico válida.',
            'password.required' => 'El campo contraseña es obligatorio.',
            'email.unique'=> 'El email ya existe'
        ];
    }
}
