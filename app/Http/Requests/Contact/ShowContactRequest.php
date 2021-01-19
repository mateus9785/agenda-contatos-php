<?php

namespace App\Http\Requests\Contact;

use Illuminate\Foundation\Http\FormRequest;

class ShowContactRequest extends FormRequest
{

    /**
     * Regras de validação dos dados de uma requisição
     *
     * @return array
     */

    public function rules()
    {
        return [
            'id' => ['integer', 'nullable'],
        ];
    }
}
