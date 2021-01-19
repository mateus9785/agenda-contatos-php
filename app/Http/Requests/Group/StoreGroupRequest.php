<?php

namespace App\Http\Requests\Group;

use Illuminate\Foundation\Http\FormRequest;

class StoreGroupRequest extends FormRequest
{

    /**
     * Regras de validação dos dados de uma requisição
     *
     * @return array
     */

    public function messages()
    {
        return [
            'name.required' => 'O nome do grupo é obrigatório',
            'name.max' => 'O nome do grupo não pode ter mais de 30 caracteres'
        ];
    }

    /**
     * Regras de validação dos dados de uma requisição
     *
     * @return array
     */

    public function rules()
    {
        return [
            'name' => ['required', 'string', 'max:30']
        ];
    }
}
