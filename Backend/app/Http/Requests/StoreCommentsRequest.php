<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreCommentsRequest extends FormRequest
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
            'post_id' => 'required|integer', // ID de la publicación a la que pertenece el comentario
            'content' => 'required|string', // Contenido del comentario
            'comment_id' => 'nullable|integer', // ID del comentario padre en caso de que exista
        ];
    }

    public function messages()
    {
        return [
            'post_id' => [
                'required' => 'El id de la publicacion es obligatorio',
                'integer' => 'Tipo de dato incorrecto',
            ],
            'content' => [
                'string' => 'El dato no es el adecuado, string requerido',
                'required' => 'el contenido del comentario es obligatorio',
            ],
            'comment_id' => [
                'nullable' => 'El id del comentario puede ser nulo',
                'integer' => 'Tipo de dato incorrecto',
            ]
        ];
    }
}
