<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePostsRequest extends FormRequest
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
            'image' => 'string', // Imagen del post
            'title' => 'required|string|max:255', // Titulo del post
            'description' => 'string|max:300', // Descripción del post
            'post_type_id' => 'required|integer', // Id de tipo de publicación
            'start_date' => 'date|after_or_equal:today', // Fecha en la que inicia el evento
            'end_date' => 'date|after:start_date', // Fecha en la que termina el evento
        ];
    }

    public function messages(): array
    {
        return [
            'image' => 'El dato no es el adecuado, string requerido',
            'title' => [
                'required' => 'El titulo de la publicación es obligatorio',
                'max' => 'El titulo es demasiado largo',
            ],
            'description' => [
                'string' => 'El dato no es el adecuado, string requerido',
                'max' => 'La descripción es demasiada larga',
            ],
            'post_type_id' => [
                'required' => 'El tipo de publicación es obligatorio',
                'integer' => 'Tipo de dato incorrecto',
            ],
            'start_date' => [
                'date' => 'La fecha no tiene el formato correcto',
                'after_or_equal' => 'No puedes poner una fecha anterior a hoy',
            ],
            'end_date' => [
                'date' => 'La fecha no tiene el formato correcto',
                'after' => 'No puedes poner una fecha anterior a la fecha de inicio',
            ]
        ];
    }
}
