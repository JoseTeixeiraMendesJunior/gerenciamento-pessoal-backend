<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class TaskRequest extends FormRequest
{
    /**
     * Lista de validação dos dados do request, de acordo com as regras de negócio.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' =>  'required|string|max:255',
            'description' => 'nullable|string|max:255',
            'due_date' => 'required|date',
            'priority' => 'required|string|in:low,medium,high',
            'type' => 'required|string|in:only,daily,weekly,monthly',
        ];
    }

    /**
     * Lista de exceções das regras de negócio, tratadas.
     * @return array
     */
    public function messages()
    {
        return [
            'name.required' => 'O campo name é obrigatório.',
            'name.max' => 'O campo name tem um tamanho máximo de 255 caracteres.',
            'description.max' => 'O campo description tem um tamanho máximo de 255 caracteres.',
            'due_date.required' => 'O campo due_date é obrigatório.',
            'due_date.date' => 'O campo due_date deve ser uma data válida.',
            'priority.required' => 'O campo priority é obrigatório.',
            'priority.in' => 'O campo priority deve ser um dos valores: low, medium, high.',
            'type.required' => 'O campo type é obrigatório.',
            'type.in' => 'O campo type deve ser um dos valores: only, daily, weekly, monthly.',
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
