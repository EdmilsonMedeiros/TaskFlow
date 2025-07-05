<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProfileRequest extends FormRequest
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
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255',
            'password' => 'nullable|string|min:6|confirmed',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'O nome é obrigatório',
            'email.required' => 'O email é obrigatório',
            'password.string' => 'A senha deve ser uma string',
            'email.string' => 'O email deve ser uma string',
            'email.max' => 'O email deve ter no máximo 255 caracteres',
            'name.string' => 'O nome deve ser uma string',
            'name.max' => 'O nome deve ter no máximo 255 caracteres',
            'password.confirmed' => 'As senhas não conferem',
            'password.min' => 'A senha deve ter no mínimo 8 caracteres',
        ];
    }
}
