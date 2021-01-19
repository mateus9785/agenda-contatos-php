<?php

namespace App\Http\Requests\Group;

use Illuminate\Foundation\Http\FormRequest;

class IndexGroupRequest extends FormRequest
{
    /**
     * Regras de validação dos dados de uma requisição
     *
     * @return array
     */

    public function rules()
    {
        return [
            'per_page' => ['integer', 'nullable'],
        ];
    }
}
