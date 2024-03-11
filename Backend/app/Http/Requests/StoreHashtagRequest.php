<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
class StoreHashtagRequest extends FormRequest
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
            'name' => [
                'required',
                'string',
                
            ],
        ];
    }
    public function messages(): array
    {
       return [
            'name' => [
                'required' =>'El nombre del HashTag es necesario',
                'string' => 'el dato no es adecuado , string requerido',
            ]
       ];
    }
}
