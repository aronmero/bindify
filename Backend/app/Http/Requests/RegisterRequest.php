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
            // 'avatar' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
            'email' => ['required', 'unique:users,email'],
            'phone' => ['unique:users,phone'],
            'username' => ['required', 'unique:users,username'],
            'municipality_id' => ['exists:municipalities,id'],
            'empresa' => ['required', 'boolean'],
            'name'=> ['required'],
            'verification_token'=> ['exists:verification_tokens, token'],
        ];
    }
}
