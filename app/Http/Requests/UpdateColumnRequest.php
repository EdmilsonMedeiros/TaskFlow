<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateColumnRequest extends FormRequest
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
     * @param  \Illuminate\Contracts\Validation\Validator $validator
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
            'color' => 'required|string|max:255',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'O nome da coluna é obrigatório',
            'name.string' => 'O nome da coluna deve ser uma string',
            'name.max' => 'O nome da coluna deve ter no máximo 255 caracteres',
            'color.required' => 'A cor da coluna é obrigatória',
            'color.string' => 'A cor da coluna deve ser uma string',
            'color.max' => 'A cor da coluna deve ter no máximo 255 caracteres',
        ];
    }
}
