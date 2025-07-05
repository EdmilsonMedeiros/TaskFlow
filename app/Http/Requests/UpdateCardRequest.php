<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCardRequest extends FormRequest
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
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'assigned_user_id' => 'nullable|exists:users,id',
        ];
    }

    public function messages(): array
    {
        return [
            'title.required' => 'O título da task é obrigatório',
            'title.string' => 'O título da task deve ser uma string',
            'title.max' => 'O título da task deve ter no máximo 255 caracteres',
            'description.string' => 'A descrição da task deve ser uma string',
            'assigned_user_id.exists' => 'O membro selecionado não existe',
        ];
    }
}
