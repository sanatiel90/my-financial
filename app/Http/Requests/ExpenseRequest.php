<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ExpenseRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'description' => 'required|max:255|min:4',
            'value' => 'required|numeric',
        ];
    }


    public function messages()
{
    return [
        'description.required' => 'Preencha a descrição',
        'description.max' => 'Informe no máximo 255 caracteres para a descrição',
        'description.min' => 'Informe no mínimo 4 caracteres para a descrição',
        'value.required'  => 'Preencha o valor',
        'value.numeric' => 'Informe um valor válido',
    ];
}
}
