<?php

namespace App\Http\Requests\Group;

use Illuminate\Foundation\Http\FormRequest;

class StoreGroupRequest extends FormRequest
{

    public function authorize()
    {
        return true;
    }

    public function messages()
    {
        return [
            'name.required' => 'O nome do grupo é obrigatório',
            'name.max' => 'O nome do grupo não pode ter mais de 30 caracteres'
        ];
    }

    public function rules()
    {
        return [
            'name' => ['required', 'string', 'max:30']
        ];
    }
}
