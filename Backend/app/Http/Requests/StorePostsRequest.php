<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePostsRequest extends FormRequest
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
            'title' => 'required|string|max:255', // Titulo del post
            'description' => 'string|max:300', // Descripción del post
            'post_type_id' => 'required|integer', // Id de tipo de publicación
        ];
    }

    public function messages(): array
    {
        return [
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
        ];
    }
}
