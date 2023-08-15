<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class RecurringTransactionRequest extends FormRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'description' => 'nullable|string|max:255',
            'amount' => 'required|numeric',
            'type' => 'required|string|in:expense,income',
            'date' => 'required|date',
            'transaction_category_id' => 'required|exists:transaction_categories,id',
            'frequency' => 'required|string|in:daily,weekly,monthly',
            'active' => 'required|boolean',
        ];
    }

    public function messages()
    {
        return [
            'description.max' => 'O campo description tem um tamanho máximo de 255 caracteres.',
            'amount.required' => 'O campo amount é obrigatório.',
            'amount.numeric' => 'O campo amount deve ser um número.',
            'type.required' => 'O campo type é obrigatório.',
            'type.in' => 'O campo type deve ser um dos valores: expense, income.',
            'date.required' => 'O campo date é obrigatório.',
            'date.date' => 'O campo date deve ser uma data válida.',
            'transaction_category_id.required' => 'O campo transaction_category_id é obrigatório.',
            'transaction_category_id.exists' => 'O campo transaction_category_id deve ser um id válido.',
            'frequency.required' => 'O campo frequency é obrigatório.',
            'frequency.in' => 'O campo frequency deve ser um dos valores: daily, weekly, monthly.',
            'active.required' => 'O campo active é obrigatório.',
            'active.boolean' => 'O campo active deve ser um booleano.',
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
