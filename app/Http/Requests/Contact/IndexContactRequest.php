<?php

namespace App\Http\Requests\Contact;

use Illuminate\Foundation\Http\FormRequest;

class IndexContactRequest extends FormRequest
{

    /**
     * Regras de validação dos dados de uma requisição
     *
     * @return array
     */

    public function rules()
    {
        return [
            'group_id' => ['integer', 'nullable'],
            'search' => ['string', 'nullable', 'max:100'],
            'per_page' => ['integer', 'nullable'],
        ];
    }
}
