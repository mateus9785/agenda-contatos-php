<?php

namespace App\Http\Requests\Contact;

use Illuminate\Foundation\Http\FormRequest;

class StoreContactRequest extends FormRequest
{
    /**
     * Mensagens de erro para cada tipo de validação
     *
     * @return array
     */

    public function messages()
    {
        return [
            'name.required' => 'O nome do contato é obrigatório',
            'name.max' => 'O nome do contato não pode ter mais de 100 caracteres',
            'addresses.*.street.required' => 'O nome da rua é obrigatório',
            'addresses.*.neighborhood.required' => 'O nome do bairro é obrigatório',
            'addresses.*.city.required' => 'O nome da cidade é obrigatório',
            'addresses.*.province.required' => 'O estado é obrigatório',
            'addresses.*.cep.required' => 'O CEP é obrigatório',
            'addresses.*.number.required' => 'O número é obrigatório',
            'addresses.*.street.max' => 'O nome da rua não pode ter mais de 100 caracteres',
            'addresses.*.neighborhood.max' => 'O nome do bairro não pode ter mais de 60 caracteres',
            'addresses.*.city.max' => 'O nome da cidade não pode ter mais de 50 caracteres',
            'addresses.*.province.max' => 'O estado não pode ter mais de 30 caracteres',
            'addresses.*.complement.max' => 'O estado não pode ter mais de 100 caracteres',
            'addresses.*.cep.max' => 'O CEP não pode ter mais de 20 caracteres',
            'addresses.*.number.max' => 'O número não pode ter mais de 10 caracteres',
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
            'name' => ['required', 'string', 'max:100'],
            'groups' => ['array'],
            'phones' => ['array'],
            'addresses' => ['array'],
            'addresses.*.street' => ['required', 'string', 'max:100'],
            'addresses.*.neighborhood' => ['required', 'string', 'max:60'],
            'addresses.*.city' => ['required', 'string', 'max:50'],
            'addresses.*.province' => ['required', 'string', 'max:30'],
            'addresses.*.complement' => ['string', 'nullable', 'max:100'],
            'addresses.*.cep' => ['required', 'string', 'max:20'],
            'addresses.*.number' => ['required', 'string', 'max:10'],
        ];
    }
}
