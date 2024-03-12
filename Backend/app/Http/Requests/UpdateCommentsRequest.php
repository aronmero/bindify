<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCommentsRequest extends FormRequest
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
            'content' => 'required|string', // Contenido del comentario
        ];
    }

    public function messages()
    {
        return [
            'content.required' => 'El contenido del comentario es obligatorio',
            'content.string' => 'El contenido del comentario debe ser una cadena',
        ];
    }
}
