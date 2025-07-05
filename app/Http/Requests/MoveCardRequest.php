<?php

namespace App\Http\Requests;

use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Http\FormRequest;

class MoveCardRequest extends FormRequest
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
            'column_id' => 'required|exists:columns,id',
            'position' => 'required|integer',
        ];
    }

    public function messages(): array
    {
        return [
            'column_id.required' => 'O ID da coluna é obrigatório',
            'column_id.exists' => 'O ID da coluna não existe',
            'position.required' => 'A posição é obrigatória',
            'position.integer' => 'A posição deve ser um número inteiro',
        ];
    }
}
