<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreReviewsRequest extends FormRequest
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
            'commerce_id' => 'required|integer', //Id del comercio 
            'comment' => 'required|string|max:200', //Contenido del comentario
            'note' => 'required|integer|min:0|max:5', //Nota del comercio
        ];
    }

    public function messages(): array
    {
        return [
            'commerce_id'=> [
                'required'=> 'Es necesario el id del comercio a valorar',
                'integer' => 'Tipo de dato incorrecto, integer requerido',
            ],
            'comment' => [
                'required'=> 'El comentario es un campo obligatorio',
                'string' => 'Tipo de dato incorrecto, string requerido',
                'max' => 'El comentario es demasiado largo',
            ],
            'note' => [
                'required'=> 'La nota es un campo obligatorio',
                'integer' => 'Tipo de dato incorrecto, integer requerido',
                'min' => 'La nota no puede ser menor que 0',
                'max' => 'La nota no puede ser mayor que 5',
            ]
        ];
    }
}
