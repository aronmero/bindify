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
            'image' => 'nullable|string', // Imagen del post
            'title'=> 'required|string|max:255', // Titulo del post
            'description'=> 'nullable|string|max:300', // Descripción del post
            'post_type_id'=> 'required|integer', // Id de tipo de publicación
            'start_date'=> 'nullable|date|after_or_equal:today', // Fecha en la que inicia el evento
            'end_date'=> 'nullable|date|after:start_date', // Fecha en la que termina el evento
        ];
    }

    
}
