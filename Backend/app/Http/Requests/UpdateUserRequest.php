<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateUserRequest extends FormRequest
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
            'email' => 'required|email', // Email del usuario
            'password' => 'required', //Contraseña del usuario
            'phone' => 'required|integer|max_digits:9', // Numero de telefono del usuario
            'municipality_id' => 'required|integer', //Id del municipio
            'username' => 'required|string', // Nombre de usuario
            'name' => 'required|string', // Nombre real del usuario
            'address' => 'string', // Dirección del comercio
            'category_id' => 'integer', // Categoría del comercio
            'empresa' => 'boolean', // Booleano que comprueba si es una empresa
            'schedule' => 'string', // Horario de una empresa
            'description' => 'string|max:300', // Descripción de la empresa
            'gender' => 'string', // Género del cliente
            'birth_date' => 'date|before:today', // Fecha de nacimiento del cliente
        ];
    }

    public function messages(): array
    {
        return [
            'email' => [
                'required' => 'El email es requerido',
                'email' => 'El campo no cumple con el formato de un correo electronico',
            ],
            'password' => [
                'required' => 'La contraseña es requerida',
            ],
            'phone' => [
                'required' => 'El teléfono es requerido',
                'integer' => 'Formato de dato incorrecto, integer requerido',
                'max_digits' => 'El numero es demasiado largo para un número de teléfono'
            ],
            'municipality_id' => [
                'required' => 'El id del municipio es requerido',
                'integer' => 'Formato de dato incorrecto, integer requerido',
            ],
            'username' => [
                'required' => 'El nombre de usuario es requerido',
                'string' => 'Formato de dato incorrecto, string requerido',
            ],
            'name' => [
                'required' => 'El nombre real del usuario/comercio es requerido',
                'string' => 'Formato de dato incorrecto, string requerido',
            ],
            'address' => 'Formato de dato incorrecto, string requerido',
            'category_id' => [
                'integer' => 'Formato de dato incorrecto, integer requerido',
            ],
            'empresa' => 'El dato no es un booleano',
            'schedule' => 'Formato de dato incorrecto, string requerido',
            'description' => [
                'string' => 'Formato de dato incorrecto, string requerido',
                'max' => 'La descripción es demasiada larga'
            ],
            'gender' => 'Formato de dato incorrecto, string requerido',
            'bith_date' => [
                'date' => 'El formato de la fecha es incorrecto',
                'before' => 'No puedes nacer hoy'
            ],
            'banner' => 'El archivo no es una imagen, (jpg, jpeg, png, bmp, gif, svg, or webp)',
        ];
    }
}
