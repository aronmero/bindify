<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
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
            'password' => ['required'],
            'email' => ['required', 'unique:users,email'],
            'phone' => ['required', 'unique:users,phone'],
            'username' => ['required', 'unique:users,username'],
            'municipality_id' => ['exists:municipalities,id'],
            'empresa' => ['required', 'boolean'],
            'name'=> ['required'],
        ];
    }
}
