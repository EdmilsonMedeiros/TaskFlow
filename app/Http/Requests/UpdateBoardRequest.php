<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Validator;

class UpdateBoardRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Handle a failed validation attempt.
     *
     * @param  \Illuminate\Contracts\Validation\Validator  $validator
     * @return \Illuminate\Http\JsonResponse
     */
    protected function failedValidation(\Illuminate\Contracts\Validation\Validator $validator)
    {
        $errors = $validator->errors();
        throw new \Illuminate\Validation\ValidationException($validator, response()->json(['error' => $errors], 422));
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
            'description' => 'nullable|string|max:255',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'O nome do board é obrigatório',
            'name.string' => 'O nome do board deve ser uma string',
            'name.max' => 'O nome do board deve ter no máximo 255 caracteres',
            'description.string' => 'A descrição do board deve ser uma string',
            'description.max' => 'A descrição do board deve ter no máximo 255 caracteres',
        ];
    }
}
