<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class ShoppingListRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name' =>  'required|string|max:255',
            'items' => 'required|array',
			'items.*.name' => 'required|string|max:255',
			'items.*.quantity' => 'required|integer|min:1',
        ];
    }

	public function messages()
    {
        return [
            'name.required' => 'O campo name é obrigatório.',
            'name.max' => 'O campo name tem um tamanho máximo de 255 caracteres.',
			'items.required' => 'O campo items é obrigatório.',
			'items.array' => 'O campo items deve ser um array.',
			'items.*.name.required' => 'O campo name é obrigatório.',
			'items.*.name.max' => 'O campo name tem um tamanho máximo de 255 caracteres.',
			'items.*.quantity.required' => 'O campo quantity é obrigatório.',
			'items.*.quantity.integer' => 'O campo quantity deve ser um número inteiro.',
			'items.*.quantity.min' => 'O campo quantity deve ser um número inteiro maior que 0.',
        ];
    }

	public function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json($validator->errors(), 422));
    }
}
