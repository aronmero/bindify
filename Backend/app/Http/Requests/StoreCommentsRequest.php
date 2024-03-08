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
            'user_id' => 'required|integer', // ID del usuario que realiza el comentario
            'content' => 'required|string', // Contenido del comentario
            'comment_id' => 'nullable|integer', // ID del comentario padre en caso de que exista
        ];
    }

    


}
