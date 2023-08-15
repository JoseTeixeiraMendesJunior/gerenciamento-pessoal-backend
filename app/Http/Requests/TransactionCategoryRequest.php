<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class TransactionCategoryRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'description' => 'nullable|string|max:255',
            'type' => 'required|string|in:expense,income',
            'name' => 'required|string|max:255',
        ];
    }

    public function messages()
    {
        return [
            'description.max' => 'O campo description tem um tamanho máximo de 255 caracteres.',
            'type.required' => 'O campo type é obrigatório.',
            'type.in' => 'O campo type deve ser um dos valores: expense, income.',
            'name.required' => 'O campo name é obrigatório.',
            'name.max' => 'O campo name tem um tamanho máximo de 255 caracteres.',
        ];
    }

    /**
     * Dispara um Http Reponse Exception, contendo as falhas de validações refentes as rules
     * @param Validator $validator
     * @return void
     */
    public function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json($validator->errors(), 422));
    }
}
